<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends SearchableController
{
    const int MAX_ITEMS = 5;
    #[\Override]
    function getQuery(): Builder
    {
        return  Product::orderBy('code');
    }
    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    function filterByPrice(
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    #[\Override]
    function filter(
        Builder|Relation $query,
        array $criteria,
    ): Builder|Relation {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }
    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('shops')->with('category'); // week9


        return view('products.list', [
            'criteria' => $criteria,
            'products' => $query->paginate(self::MAX_ITEMS),
        ]);
    }
    function view(string $productCode): View
    {
        // โหลดข้อมูล Product พร้อมกับ Category ที่เกี่ยวข้อง
        $product = Product::where('code', $productCode)
            ->with('category')
            ->firstOrFail();

        return view('products.view', [
            'product' => $product,
        ]);
    }
    function showCreateForm(): View
    {
        return view('products.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $product = Product::create($request->getParsedBody());/*เอาพาสิทบอดี้มาแล้วครีเอทเป็นโปรดัก */

        return redirect()->route('products.list');/*เบสแพคทีค อัพ้เดตข้อมุลไปดาต้าเบส รีไดเรกไปหน้าลิส อย่าให้อยู่หน้าเดิม */
    }


    function showUpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('products.update-form', [
            'product' => $product,/* ต้องการข้อมูลเดิมจึงส่งไปให้*/
        ]);
    }

    function update(ServerRequestInterface $request, string $productCode,): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        /** */
        $product->save();

        return redirect()->route('products.view', [
            'product' => $product->code,
            /**ส่งโพรดักโค้ดไปด้วยเพราะ วิวต้องการ */
        ]);
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        /**ก่อนจะดีลีทต้องเอาโพรดักมาก่อน */
        $product->delete();

        return redirect()->route('products.list');
    }

    // week9
    function viewShops(
        ServerRequestInterface $request, //ดึงตัวโปรดักให้ได้ก่อน
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams()); //รับมาแบบเกทแล้วส่งไปพรีแพรที่ช้อปคอนโทรลเลอร์

        $query = $shopController->filter(
            $product->shops(), //ช้อปที่มีรีเลชั่นกับโพรดักตัวนี้
            $criteria
        )
            ->withCount('products');

        return view('products.view-shops', [
            'product' => $product,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }

    function showAddShopsForm(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode,
    ): View {
        $product = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product) {
                    $innerQuery->where('code', $product->code);
                },
            );
        $query = $shopController
            ->filter($query, $criteria)
            ->withCount('products');

        return view('products.add-shops-form', [
            'product' => $product,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }

    function addShop(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode,
    ): RedirectResponse {

        $product = $this->find($productCode);
        $data = $request->getParsedBody();

        $shop = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product): void {
                    $innerQuery->where('code', $product->code);
                },
            )
            ->where('code', $data['shop'])
            ->firstOrFail();
        $product->shops()->attach($shop);

        return redirect()->back();
    }
}

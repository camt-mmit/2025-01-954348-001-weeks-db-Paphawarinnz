<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ShopController extends SearchableController
{
    const int MAX_ITEMS = 5;
    #[\Override]
    function getQuery(): Builder
    {
        return  Shop::orderBy('code');
    }
     
    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');


        return view('shops.list', [
            'criteria' => $criteria,
            'shops' => $query->paginate(self::MAX_ITEMS),
        ]);
    }

    function view(string $shopCode): View
    {
        $shop =  $this->find($shopCode);

        return view('shops.view', [
            'shop' => $shop,
        ]);
    }
    function showCreateForm(): View
    {
        return view('shops.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $shop = shop::create($request->getParsedBody());/*เอาพาสิทบอดี้มาแล้วครีเอทเป็นโปรดัก */

        return redirect()->route('shops.list');/*เบสแพคทีค อัพ้เดตข้อมุลไปดาต้าเบส รีไดเรกไปหน้าลิส อย่าให้อยู่หน้าเดิม */
    }


     function showUpdateForm(string $shopCode): View
    {
        $shop = $this->find($shopCode);

        return view('shops.update-form', [
            'shop' => $shop,/* ต้องการข้อมูลเดิมจึงส่งไปให้*/
        ]);
    }

    function update( ServerRequestInterface $request, string $shopCode,): RedirectResponse {
        $shop = $this->find($shopCode);
        $shop->fill($request->getParsedBody());/** */
        $shop->save();

        return redirect()->route('shops.view', [
            'shop' => $shop->code,/**ส่งโพรดักโค้ดไปด้วยเพราะ วิวต้องการ */
        ]);
    }   

      function delete(string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);/**ก่อนจะดีลีทต้องเอาโพรดักมาก่อน */
        $shop->delete();

        return redirect()->route('shops.list');
    }
#[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        parent::applyWhereToFilterByTerm($query,$word);
        // กำหนดการค้นหาสำหรับ Shop
        $query
            ->orWhere('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%")
            ->orWhere('owner', 'LIKE', "%{$word}%");
    }

     function viewProducts(
        ServerRequestInterface $request,//ดึงตัวโปรดักให้ได้ก่อน
        ProductController $productController,
        string $shopCode
    ): View {
        $shop = $this->find($shopCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());//รับมาแบบเกทแล้วส่งไปพรีแพรที่ช้อปคอนโทรลเลอร์

        $query = $productController 
            //$shop->products(), //ช้อปที่มีรีเลชั่นกับโพรดักตัวนี้
/// $criteriฟ )
           // ->withCount('shops');
            ->filter($shop->products(), $criteria)
            ->with('category')->withCount('shops');
         


            
        return view('shops.view-products', [
            'shop' => $shop,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::MAX_ITEMS),
        
        ]);
    }
  

}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends SearchableController
{
    const int MAX_ITEMS = 5;
    #[\Override]
    function getQuery(): Builder
    {
        return  Category::orderBy('code');
    }
     
    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');


        return view('categories.list', [
            'criteria' => $criteria,
            'categories' => $query->paginate(self::MAX_ITEMS),
        ]);
    }

    function view(string $categoryCode): View
    {
        $category =  $this->find($categoryCode);

        return view('categories.view', [
            'category' => $category,
        ]);
    }
    function showCreateForm(): View
    {
        return view('categories.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $category = Category::create($request->getParsedBody());/*เอาพาสิทบอดี้มาแล้วครีเอทเป็นโปรดัก */

        return redirect()->route('categories.list');/*เบสแพคทีค อัพ้เดตข้อมุลไปดาต้าเบส รีไดเรกไปหน้าลิส อย่าให้อยู่หน้าเดิม */
    }


     function showUpdateForm(string $categoryCode): View
    {
        $category= $this->find($categoryCode);

        return view('categories.update-form', [
            'category' => $category,/* ต้องการข้อมูลเดิมจึงส่งไปให้*/
        ]);
    }

    function update( ServerRequestInterface $request, string $categoryCode,): RedirectResponse {
        $category = $this->find($categoryCode);
        $category->fill($request->getParsedBody());/** */
        $category->save();

        return redirect()->route('categories.view', [
            'category' => $category->code,/**ส่งโพรดักโค้ดไปด้วยเพราะ วิวต้องการ */
        ]);
    }   

      function delete(string $categoryCode): RedirectResponse
    {
        $category = $this->find($categoryCode);/**ก่อนจะดีลีทต้องเอาโพรดักมาก่อน */
        $category->delete();

        return redirect()->route('categories.list');
    }
 function viewProducts(
        ServerRequestInterface $request,//ดึงตัวโปรดักให้ได้ก่อน
        ProductController $productController,
        string $categoryCode
    ): View {
        $category = $this->find($categoryCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());//รับมาแบบเกทแล้วส่งไปพรีแพรที่ช้อปคอนโทรลเลอร์

        $query = $productController ->filter(
            $category->products(), //ช้อปที่มีรีเลชั่นกับโพรดักตัวนี้
            $criteria
            )
            ->withCount('shops')->with('category');
         


            
        return view('categories.view-products', [
            'category' => $category,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::MAX_ITEMS),
        
        ]);
    }
  

   

}
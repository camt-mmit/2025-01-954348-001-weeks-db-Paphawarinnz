<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::controller(ProductController::class)
  ->prefix('/products')
  ->name('products.')

  ->group(static function (): void {
    Route::get('', 'list')->name('list');
    Route::get('/create', 'showCreateForm')->name('create-form');
    Route::post('/create', 'create')->name('create');
    /* Route::get('/{product}', 'view')->name('view'); จากตัวนี้กลายเป็นพรีฟิก*/

    Route::prefix('/{product}')->group(static function (): void {
      Route::get('', 'view')->name('view');

      Route::get('/update', 'showUpdateForm')->name('update-form');
      Route::post('/update', 'update')->name('update');
      Route::post('/delete', 'delete')->name('delete');

      Route::prefix('/shops')->group(static function (): void {
        Route::get('', 'viewShops')->name('view-shops');
        Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
        Route::post('/add', 'addShop')->name('add-shop');
      });
    });
  });


Route::controller(ShopController::class)
  ->prefix('/shops')
  ->name('shops.')
  ->group(static function (): void {
    Route::get('', 'list')->name('list');
    Route::get('/create', 'showCreateForm')->name('create-form');
    Route::post('/create', 'create')->name('create');


    Route::prefix('/{shop}')->group(static function (): void {
      Route::get('', 'view')->name('view');
      Route::get('/products', 'viewProducts',)->name('view-products');
      Route::get('/update', 'showUpdateForm')->name('update-form');
      Route::post('/update', 'update')->name('update');
      Route::post('/delete', 'delete')->name('delete');
    });
  });
Route::controller(CategoryController::class)
  ->prefix('/categories')
  ->name('categories.')
  ->group(static function (): void {
    Route::get('', 'list')->name('list');
    Route::get('/create', 'showCreateForm')->name('create-form');
    Route::post('/create', 'create')->name('create');


    Route::prefix('/{category}')->group(static function (): void {
      Route::get('', 'view')->name('view');
      Route::get('/products', 'viewProducts',)->name('view-products');
      Route::get('/update', 'showUpdateForm')->name('update-form');
      Route::post('/update', 'update')->name('update');
      Route::post('/delete', 'delete')->name('delete');
    });
  });

<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function(){
    Route::get('/products', [ProductController::class, 'index'])->name('main');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category');

    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product')->whereNumber('id'); // страница товара

    Route::post('/cart', [CartController::class, 'update'])->name('addToCart'); // добавить в корзину
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('destroyFromCart'); // удалить из корзины
    Route::get('/cart', [CartController::class, 'index'])->name('cart'); // список товаров в корзине

    Route::post('/order', [OrderController::class, 'store'])->name('order'); // оформить заказ

    Route::get('/user', [UserController::class, 'index'])->name('user');
});


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

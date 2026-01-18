<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'Index']);
Route::get('/product/{slug}/{id}',[HomeController::class,'GetProduct']);
Route::get('/shop',[ShopController::class,'Index']);
Route::get('/cart',[CartController::class,'Index']);
Route::post('/addCart',[CartController::class,'Create']);
Route::post('/updateCart',[CartController::class,'Update']);
Route::post('/deleteCart',[CartController::class,'Delete']);

Route::get('/register',[AuthController::class,'signup']);
Route::post('/register',[AuthController::class,'register'])->name('auth.register');

Route::get('/login',[AuthController::class,'signin']);
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');

Route::get('/thanh-toan',[InvoiceController::class,'Index']);
Route::post('/thanh-toan',[InvoiceController::class,'Create'])->name('invoice.create');

Route::get('/dashboard',[DashboardController::class, 'Index']);

Route::get('/admin/category',[CategoryController::class, 'Index'])->name('category.index');
Route::get('/admin/category/create',[CategoryController::class, 'Create'])->name('category.create');
Route::post('/admin/category/create',[CategoryController::class, 'Store'])->name('category.store');
Route::get('/admin/category/edit/{id}',[CategoryController::class, 'Edit']);
Route::post('/admin/category/update',[CategoryController::class, 'Update'])->name('category.update');

Route::post('/admin/category/delete',[CategoryController::class, 'Delete'])->name('category.delete');

Route::get('/admin/brand',[BrandController::class, 'Index'])->name('brand.index');
Route::get('/admin/brand/create',[BrandController::class, 'Create'])->name('brand.create');
Route::post('/admin/brand/create',[BrandController::class, 'Store'])->name('brand.store');
Route::get('/admin/brand/edit/{id}',[BrandController::class, 'Edit']);

Route::post('/admin/brand/update',[BrandController::class, 'Update'])->name('brand.update');

Route::post('/admin/brand/delete',[BrandController::class, 'Delete'])->name('brand.delete');

Route::get('/admin/product',[ProductController::class, 'Index'])->name('product.index');
Route::get('/admin/product/create',[ProductController::class, 'Create'])->name('product.create');
Route::post('/admin/product/create',[ProductController::class, 'Store'])->name('product.store');


Route::get('/admin/product/edit/{id}',[ProductController::class, 'Edit'])->name('product.edit');
Route::post('/admin/product/edit/{id}',[ProductController::class, 'Update'])->name('product.update');
Route::post('/admin/product/delete',[ProductController::class, 'Delete'])->name('product.delete');

Route::post('/admin/product/size/create',[ProductController::class, 'CreateSize'])->name('productsize.create');

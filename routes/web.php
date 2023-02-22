<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/', [ProductController::class, 'addToCart'])->name('cart.add');
Route::delete('/{id}',[ProductController::class,'removeCartItem'])->name('cart.remove');
Route::get('/login',function () {return view('auth.login');})->name('auth.login');
Route::get('/add',function () {return view('anadirproducto');})->name('anadirproducto');

//Route::get('/products/{id}',function () {return view('modificarproducto');})->name('product.edit');
Route::resource('/products', ProductController::class)->except('edit');

Route::get('/products/{product}',[ProductController::class,'edit'])->name('product.edit');

//Route::get('/products/{id}',function () {return view('modificarproducto');})->name('product.update');
Route::apiResource('ticket', \App\Http\Controllers\TicketController::class);
Route::apiResource('product', \App\Http\Controllers\ProductController::class);
Auth::routes();

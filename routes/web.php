<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return inertia('Home');
})->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{product:slug}', [CatalogController::class, 'show'])->name('product.show');

// Carrito (session)
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout simple por WhatsApp (genera mensaje)
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Informativas
Route::inertia('/shipping', 'Shipping')->name('shipping');
Route::inertia('/authenticity', 'Authenticity')->name('authenticity');
Route::inertia('/faq', 'Faq')->name('faq');
Route::inertia('/how-to-buy', 'HowToBuy')->name('howToBuy');    
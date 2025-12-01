<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductController as ShopProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;

// لوحة تحكم المدير
Route::resource('admin/products', ProductController::class);

// واجهة الموقع الرئيسية
Route::get('/', [ShopProductController::class, 'showProducts'])->name('products.list');
Route::get('/product/{id}', [ShopProductController::class, 'show'])->name('products.show');

// سلة التسوق
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/coupon', [CartController::class, 'coupon'])->name('cart.coupon');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// الطلبات والدفع
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');

// إدارة الطلبات
Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
Route::post('/admin/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');


Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

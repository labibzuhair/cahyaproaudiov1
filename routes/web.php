<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\TransactionsController;


// Route::get('/', function () {
//     return view('layouts/auth/login');
// });

Route::get('/', [BerandaController::class, 'beranda'])->name('beranda');

Route::get('/registration', [AuthController::class, 'registration']);
Route::post('/registration_post', [AuthController::class, 'registration_post'])->name('registration_post');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_post', [AuthController::class, 'login_post'])->name('login_post');

Route::get('/forgot', [AuthController::class, 'forgot']);
Route::post('/forgot_post', [AuthController::class, 'forgot_post']);

Route::get('reset/{token}', [AuthController::class, 'getReset']);
Route::post('reset_post/{token}', [AuthController::class, 'postReset'])->name('reset_post');
Route::get('/logout', [AuthController::class, 'logout']);




// Grup rute untuk admin
Route::group(['middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/admin/beranda', [BerandaController::class, 'beranda'])->name('beranda');

    Route::get('/admin/produks', [ProdukController::class, 'index'])->name('produks.index');
    Route::get('/admin/produks/create', [ProdukController::class, 'create'])->name('produks.create');
    Route::post('/admin/produks', [ProdukController::class, 'store'])->name('produks.store');
    Route::get('/admin/produks/{produk}/edit', [ProdukController::class, 'edit'])->name('produks.edit'); // Ubah ini dari post ke get
    Route::put('/admin/produks/{produk}', [ProdukController::class, 'update'])->name('produks.update');
    Route::delete('/admin/produks/{produk}', [ProdukController::class, 'destroy'])->name('produks.destroy');

    Route::get('/admin/districts/search', [DistrictController::class, 'search'])->name('districts.search');
    Route::get('/admin/districts', [DistrictController::class, 'index'])->name('districts.index');
    Route::post('/admin/districts', [DistrictController::class, 'store'])->name('districts.store');
    Route::put('/admin/districts/{id}', [DistrictController::class, 'update'])->name('districts.update');


    Route::get('/admin/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/admin/transactions/create', [TransactionsController::class, 'create'])->name('transactions.create');
    Route::post('/admin/transactions', [TransactionsController::class, 'store'])->name('transactions.store');
    Route::get('/admin/transactions/{id}', [TransactionsController::class, 'show'])->name('transactions.show');
    Route::get('/admin/transactions/{id}/edit', [TransactionsController::class, 'edit'])->name('transactions.edit');
    Route::put('/admin/transactions/{id}', [TransactionsController::class, 'update'])->name('transactions.update');
    Route::delete('/admin/transactions/{id}', [TransactionsController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});


// Grup rute untuk owner
Route::group(['middleware' => 'owner', 'name' => 'owner'], function () {
    Route::get('/owner/beranda', [BerandaController::class, 'beranda'])->name('owner/beranda');

});

// Grup rute untuk customer
Route::group(['middleware' => 'customer', 'as' => 'customer.'], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{produkId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{produkId}', [CartController::class, 'remove'])->name('cart.remove');


    // Rute untuk checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

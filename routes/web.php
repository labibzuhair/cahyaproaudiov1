<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\HistoryController;


// Route::get('/', function () {
//     return view('layouts/auth/login');
// });

Route::get('/', [BerandaController::class, 'index'])->name('home');

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

    Route::get('/admin/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/admin/transactions/create', [TransactionsController::class, 'create'])->name('transactions.create');
    Route::post('/admin/transactions', [TransactionsController::class, 'store'])->name('transactions.store');


    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});


// Grup rute untuk owner
Route::group(['middleware' => 'owner', 'name' => 'owner'], function () {
    Route::get('/owner/beranda', [BerandaController::class, 'beranda'])->name('owner/beranda');

});

// Grup rute untuk customer
Route::group(['middleware' => 'customer', 'name' => 'customer'], function () {
    Route::get('/customer/beranda', [BerandaController::class, 'beranda'])->name('customer/beranda');


    // Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    // Route::get('/transactions/create', [TransactionsController::class, 'create'])->name('transactions.create');
    // Route::post('/transactions', [TransactionsController::class, 'store'])->name('transactions.store');

    // Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

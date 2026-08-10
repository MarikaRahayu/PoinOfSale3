<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanController;


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Halaman Login
    Route::get('/login', [
        AuthController::class,
        'index'
    ])->name('login');


    // Proses Login
    Route::post('/auth', [
        AuthController::class,
        'auth'
    ])->name('auth');

});


/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    Route::middleware('role:admin')->group(function () {

    Route::resource('users', UserController::class);

    Route::resource('jenis-produk', JenisProdukController::class);

});


    /*
    |--------------------------------------------------------------------------
    | Tentang
    |--------------------------------------------------------------------------
    */

    Route::get('/tentang', function () {

        return view('tentang');

    })->name('tentang');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');


   /*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin')->group(function () {

    // User
    Route::resource('users', UserController::class);

    // Jenis Produk
    Route::resource(
        'jenis-produk',
        JenisProdukController::class
    )->except([
        'show'
    ]);

});

    /*
    |--------------------------------------------------------------------------
    | Admin & Kasir
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,kasir')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Produk
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'produk',
            ProdukController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Penjualan
        |--------------------------------------------------------------------------
        */

        Route::controller(PenjualanController::class)->group(function () {


            /*
            |--------------------------------------------------------------
            | Halaman utama
            |--------------------------------------------------------------
            */

            Route::get(
                '/penjualan',
                'index'
            )->name('penjualan.index');


            /*
            |--------------------------------------------------------------
            | Tambah transaksi
            |--------------------------------------------------------------
            */

            Route::get(
                '/penjualan/create',
                'create'
            )->name('penjualan.create');


            /*
            |--------------------------------------------------------------
            | Simpan transaksi
            |--------------------------------------------------------------
            */

            Route::post(
                '/penjualan',
                'store'
            )->name('penjualan.store');


            /*
            |--------------------------------------------------------------
            | Checkout
            |--------------------------------------------------------------
            */

            Route::post(
                '/penjualan/checkout',
                'checkout'
            )->name('penjualan.checkout');


            /*
            |--------------------------------------------------------------
            | Cancel transaksi
            |--------------------------------------------------------------
            */

            Route::post(
                '/penjualan/cancel',
                'cancel'
            )->name('penjualan.cancel');


            /*
            |--------------------------------------------------------------
            | Hapus item penjualan
            |--------------------------------------------------------------
            */

            Route::delete(
                '/penjualan/item/{id}',
                'destroyItem'
            )->name('penjualan.destroyItem');


            /*
            |--------------------------------------------------------------
            | Edit transaksi
            |--------------------------------------------------------------
            */

            Route::get(
                '/penjualan/{penjualan}/edit',
                'edit'
            )->name('penjualan.edit');


            /*
            |--------------------------------------------------------------
            | Update transaksi
            |--------------------------------------------------------------
            */

            Route::put(
                '/penjualan/{penjualan}',
                'update'
            )->name('penjualan.update');


            /*
            |--------------------------------------------------------------
            | Hapus transaksi
            |--------------------------------------------------------------
            */

            Route::delete(
                '/penjualan/{penjualan}',
                'destroy'
            )->name('penjualan.destroy');


            /*
            |--------------------------------------------------------------
            | Detail transaksi
            |--------------------------------------------------------------
            */

            Route::get(
                '/penjualan/{penjualan}',
                'show'
            )->name('penjualan.show');

        });

    });

});
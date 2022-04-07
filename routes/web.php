<?php

use Illuminate\Support\Facades\Auth;
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



Auth::routes([
  'register' => false, // Register Routes...
  'reset' => false, // Reset Password Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'validasi', 'as' => 'validasi.'], function(){
        Route::get('', [App\Http\Controllers\ValidasiController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\ValidasiController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'lolos', 'as' => 'lolos.'], function(){
        Route::get('', [App\Http\Controllers\LolosController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\LolosController::class, 'store'])->name('store');
        Route::get('/maba/show/{id}', [App\Http\Controllers\LolosController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function(){
        Route::get('', [App\Http\Controllers\PembayaranController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\PembayaranController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'rekomendasi', 'as' => 'rekomendasi.'], function(){
        Route::get('/internal', [App\Http\Controllers\RekomendasiController::class, 'internal'])->name('internal');
        Route::get('/eksternal', [App\Http\Controllers\RekomendasiController::class, 'eksternal'])->name('eksternal');
    });

    Route::group(['prefix' => 'nim', 'as' => 'nim.'], function(){
        Route::get('', [App\Http\Controllers\NimController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'prodi', 'as' => 'prodi.'], function(){
        Route::get('', [App\Http\Controllers\ProdiController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\ProdiController::class, 'store'])->name('store');
        Route::put('', [App\Http\Controllers\ProdiController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'pengguna', 'as' => 'pengguna.'], function(){
        Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::put('', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::post('', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/akses/{id}', [App\Http\Controllers\UserController::class, 'getPermission'])->name('getpermission');
        Route::post('/akses', [App\Http\Controllers\UserController::class, 'permission'])->name('permission');
        Route::put('/password', [App\Http\Controllers\UserController::class, 'password'])->name('password');
    });


});

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
    Route::get('/chart', [App\Http\Controllers\HomeController::class, 'chart'])->name('chart');
    Route::put('/password', [App\Http\Controllers\UserController::class, 'password'])->name('password');

    Route::group(['middleware' => ['permission:validasi'], 'prefix' => 'validasi', 'as' => 'validasi.'], function(){
        Route::get('', [App\Http\Controllers\ValidasiController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\ValidasiController::class, 'store'])->name('store');
        Route::get('/show', [App\Http\Controllers\ValidasiController::class, 'show'])->name('show');
    });

    Route::group(['middleware' => ['permission:lolos'], 'prefix' => 'lolos', 'as' => 'lolos.'], function(){
        Route::get('', [App\Http\Controllers\LolosController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\LolosController::class, 'store'])->name('store');
        Route::put('', [App\Http\Controllers\LolosController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [App\Http\Controllers\LolosController::class, 'edit'])->name('edit');
        Route::get('/maba/show/{id}', [App\Http\Controllers\LolosController::class, 'show'])->name('show');
    });

    Route::group(['middleware' => ['permission:pembayaran'], 'prefix' => 'pembayaran', 'as' => 'pembayaran.'], function(){
        Route::get('', [App\Http\Controllers\PembayaranController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\PembayaranController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'rekomendasi', 'as' => 'rekomendasi.'], function(){
        Route::post('', [App\Http\Controllers\RekomendasiController::class, 'store'])->name('store');
        Route::get('/internal', [App\Http\Controllers\RekomendasiController::class, 'internal'])->name('internal')->middleware('permission:rekom-internal');
        Route::get('/eksternal', [App\Http\Controllers\RekomendasiController::class, 'eksternal'])->name('eksternal')->middleware('permission:rekom-eksternal');
    });

    Route::group(['middleware' => ['permission:nim'], 'prefix' => 'nim', 'as' => 'nim.'], function(){
        Route::get('', [App\Http\Controllers\NimController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\NimController::class, 'store'])->name('store');
    });

    Route::group(['middleware' => ['permission:manajemen'], 'prefix' => 'prodi', 'as' => 'prodi.'], function(){
        Route::get('', [App\Http\Controllers\ProdiController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\ProdiController::class, 'store'])->name('store');
        Route::put('', [App\Http\Controllers\ProdiController::class, 'update'])->name('update');
    });

    Route::group(['middleware' => ['permission:manajemen'], 'prefix' => 'periode', 'as' => 'periode.'], function(){
        Route::get('', [App\Http\Controllers\PeriodeController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\PeriodeController::class, 'store'])->name('store');
        Route::put('', [App\Http\Controllers\PeriodeController::class, 'update'])->name('update');
    });

    Route::group(['middleware' => ['permission:manajemen'], 'prefix' => 'pengguna', 'as' => 'pengguna.'], function(){
        Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::put('', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::post('', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/akses/{id}', [App\Http\Controllers\UserController::class, 'getPermission'])->name('getpermission');
        Route::post('/akses', [App\Http\Controllers\UserController::class, 'permission'])->name('permission');
        Route::put('/password', [App\Http\Controllers\UserController::class, 'password'])->name('password');
    });

    Route::group(['middleware' => ['permission:manajemen'], 'prefix' => 'log', 'as' => 'log.'], function(){
        Route::get('', [App\Http\Controllers\LogController::class, 'index'])->name('index');
    });


});

<?php

use App\Http\Controllers\API\GrafikController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LolosController;
use App\Http\Controllers\API\NimController;
use App\Http\Controllers\API\PembayaranController;
use App\Http\Controllers\API\RekomendasiController;
use App\Http\Controllers\API\ValidasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [LoginController::class, 'index']);
Route::post('/validasi', [ValidasiController::class, 'store']);
Route::post('/lolos', [LolosController::class, 'store']);
Route::post('/pembayaran', [PembayaranController::class, 'store']);
Route::post('/nim', [NimController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [HomeController::class, 'profile']);
    Route::post('/password', [HomeController::class, 'password']);

    Route::get('/validasi', [ValidasiController::class, 'index']);
    Route::get('/validasi/search', [ValidasiController::class, 'search']);
    Route::get('/validasi/show/{id}', [ValidasiController::class, 'show']);

    Route::get('/lolos', [LolosController::class, 'index']);

    Route::get('/pembayaran', [PembayaranController::class, 'index']);

    Route::get('/rekom-internal', [RekomendasiController::class, 'internal']);
    Route::get('/rekom-eksternal', [RekomendasiController::class, 'eksternal']);

    Route::get('/nim', [NimController::class, 'index']);

    Route::get('/grafik', [GrafikController::class, 'rekap']);
    Route::get('/logout', [LoginController::class, 'logout']);
});

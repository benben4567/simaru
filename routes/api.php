<?php

use App\Http\Controllers\API\LolosController;
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

Route::get('/validasi', [ValidasiController::class, 'index']);
Route::get('/validasi/show/{id}', [ValidasiController::class, 'show']);

Route::get('/lolos', [LolosController::class, 'index']);

Route::get('/pembayaran', [PembayaranController::class, 'index']);

Route::get('/rekom-internal', [RekomendasiController::class, 'internal']);
Route::get('/rekom-eksternal', [RekomendasiController::class, 'eksternal']);

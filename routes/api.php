<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransaksiController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/midtrans-callback',[TransaksiController::class,'callback']);
Route::get('/tes',[DashboardController::class,'tes']);


Route::middleware(['auth:sanctum','throttle:120,1'])->group(function(){
    Route::get('/get-count',[DashboardController::class,'jumlah_notifikasi']);
    Route::get('/get-notifikasi',[DashboardController::class, 'get_notifikasi']);
});

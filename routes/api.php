<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\WhatsappMessageController;
use App\Http\Controllers\FonnteWebhookController;
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

Route::middleware(['auth'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recently-users', [VisitorController::class, 'recentlyUsers']);
Route::post('/midtrans-callback',[TransaksiController::class,'callback']);
Route::post('/fonnte-webhook/status',[FonnteWebhookController::class, 'status']);
Route::get('/whatsapp-messages/transaksi/{transaksi_id}', [WhatsappMessageController::class, 'getByTransaksi']);
Route::get('/whatsapp-messages/summary/{transaksi_id}', [WhatsappMessageController::class, 'getStatusSummary']);
Route::get('/whatsapp-messages/{message_id}', [WhatsappMessageController::class, 'show']);
Route::get('/tes',[DashboardController::class,'tes']);
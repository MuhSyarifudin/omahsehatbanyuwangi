<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\PaymentPageController;
use App\Http\Controllers\SendPaymentController;
use App\Http\Controllers\ShowPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index']);
Route::get('reservasi',[ReservasiController::class,'index'])->name('pesan.reservasi.terapi');
Route::post('checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::get('/reservasi/waiting-confirmation',[ReservasiController::class,'tunggu_konfirmasi'])->name('waiting.page')->middleware('prevent-back-history');
Route::get('/reservasi/detail',[ReservasiController::class,'detail_reservasi'])->name('detail.reservasi.terapi')->middleware('prevent-back-history');
Route::get('/reservasi/detail/{id}',[ShowPaymentController::class,'showPaymentPage'])->name('show.payment.page')->middleware('prevent-back-history');
Route::get('/send-payment/{id}',[SendPaymentController::class,'sendPaymentPage'])->name('send.payment.page');
Route::get('/payment-success',[PaymentPageController::class,'success'])->name('payment.success.page');
Route::get('/payment-failed',[PaymentPageController::class,'failed'])->name('payment.failed.page');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/data-reservasi',[AdminController::class,'data_reservasi'])->name('data.reservasi');
    Route::get('/search-reservasi',[AdminController::class,'search_reservasi'])->name('search.reservasi');
    Route::get('/data-user',[AdminController::class,'data_user'])->name('data.user');
    Route::get('tes',function(){
        return view('tes');
    });

    Route::resource('messages', MessageController::class);
    Route::resource('devices', DeviceController::class);

    Route::post('send-message', [DeviceController::class, 'sendMessage'])->name('send.message');
    Route::post('devices/status', [DeviceController::class, 'checkDeviceStatus']);
    Route::post('devices/activate', [DeviceController::class, 'activateDevice'])->name('devices.activate');
    Route::post('devices/disconnect', [DeviceController::class, 'disconnect'])->name('devices.disconnect');
});

Route::middleware(['auth', 'role:therapist', 'verified'])->group(function () {
    Route::get('/therapist-dashboard', [TherapistController::class, 'index'])->name('therapist.dashboard');
});

Route::get('/register-therapist', [TherapistController::class, 'create'])->name('register.therapist');
Route::post('/register-therapist', [TherapistController::class, 'store'])->name('therapist.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/get-count', [DashboardController::class, 'jumlah_notifikasi']);
    Route::get('/get-notifikasi', [DashboardController::class, 'get_notifikasi']);
    Route::get('/get-reservasi-count', [DashboardController::class, 'get_reservasi_count']);
    Route::get('/get-users-count', [DashboardController::class, 'get_users_count']);
    Route::post('/notifikasi/{id}/read',[DashboardController::class,'markAsRead']);
    Route::post('/notifikasi/read-all', [DashboardController::class, 'markAsReadAll']);
});


require __DIR__.'/auth.php';

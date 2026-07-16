<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HeartbeatController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FonnteWebhookController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JenisTerapiAdminController;
use App\Http\Controllers\KeahlianAdminController;
use App\Http\Controllers\LayananTerapiAdminController;
use App\Http\Controllers\NotificationsAdminController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\PaymentPageController;
use App\Http\Controllers\PendaftaranTerapisAdminController;
use App\Http\Controllers\PromoAdminController;
use App\Http\Controllers\ReservasiAdminController;
use App\Http\Controllers\SendPaymentController;
use App\Http\Controllers\SettingProfilController;
use App\Http\Controllers\ShowPaymentController;
use App\Http\Controllers\TerapisAdminController;
use App\Http\Controllers\UsersAdminController;

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
Route::post('checkout',[CheckoutController::class,'checkout'])->middleware(['throttle:5,1'])->name('checkout');
Route::get('/reservasi/waiting-confirmation',[ReservasiController::class,'tunggu_konfirmasi'])->name('waiting.page')->middleware('prevent-back-history');
Route::get('/reservasi/detail',[ReservasiController::class,'detail_reservasi'])->name('detail.reservasi.terapi')->middleware('prevent-back-history');
Route::get('/reservasi/detail/{order_id}',[ShowPaymentController::class,'showPaymentPage'])->name('show.payment.page')->middleware('prevent-back-history');
Route::get('/send-payment/{id}',[SendPaymentController::class,'sendPaymentPage'])->name('send.payment.page');
Route::get('/payment-success',[PaymentPageController::class,'success'])->name('payment.success.page');
Route::get('/payment-failed',[PaymentPageController::class,'failed'])->name('payment.failed.page');
Route::get('/invoice/{order_id}/{token}/',[InvoiceController::class,'index'])->name('invoice.index');
Route::get('/invoice/download/{order_id}/{token}/',[InvoiceController::class,'download'])->name('invoice.download');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/data-reservasi', [ReservasiAdminController::class, 'data_reservasi'])->name('data.reservasi');
    Route::get('/admin/data-reservasi/datatables', [ReservasiAdminController::class, 'data_reservasi_datatables'])->name('data-reservasi.datatables');
    Route::get('/admin/data-reservasi/detail/{id}',[ReservasiAdminController::class, 'data_reservasi_detail'])->name('reservasi.detail');
    Route::get('/data-notifikasi',[NotificationsAdminController::class,'data_notifikasi'])->name('data.notifikasi');
    Route::get('/admin/data-notifikasi/datatables',[NotificationsAdminController::class,'data_notifikasi_datatables'])->name('data-notifikasi.datatables');
    Route::post('/admin/data-notifikasi/{id}/read',[NotificationsAdminController::class,'markAsRead'])->name('data.notifikasi.read');
    Route::get('/data-layanan',[LayananTerapiAdminController::class,'data_layanan'])->name('data.layanan');
    Route::put('/data-layanan/{id}/update',[LayananTerapiAdminController::class,'update'])->name('data.layanan.update');
    Route::delete('/data-layanan/{id}/delete',[LayananTerapiAdminController::class,'destroy'])->name('data.layanan.destroy');
    Route::post('/data-layanan/store',[LayananTerapiAdminController::class,'store'])->name('data.layanan.store');
    Route::get('/admin/data-layanan/datatables',[LayananTerapiAdminController::class,'data_layanan_datatables'])->name('data-layanan.datatables');
    Route::get('/data-jenis-terapi',[JenisTerapiAdminController::class,'data_jenis_terapi'])->name('data.jenis.terapi');
    Route::post('/data-jenis-terapi/post',[JenisTerapiAdminController::class,'store'])->name('data.jenis.terapi.store');
    Route::put('/data-jenis-terapi/{id}/update',[JenisTerapiAdminController::class,'update'])->name('data.jenis.terapi.update');
    Route::delete('/data-jenis-terapi/{id}/delete',[JenisTerapiAdminController::class,'destroy'])->name('data.jenis.terapi.destroy');
    Route::get('/admin/data-jenis-terapi/datatables',[JenisTerapiAdminController::class,'data_jenis_terapi_datatables'])->name('data-jenis-terapi.datatables');
    Route::get('/data-users',[UsersAdminController::class,'data_users'])->name('data.users');
    Route::get('/data-users/{id}', [UsersAdminController::class, 'show']);
    Route::get('/admin/data-users/datatables',[UsersAdminController::class,'data_users_datatables'])->name('data-users.datatables');
    Route::get('/dashboard/chart/tahunan', [ChartController::class, 'chartTahunan']);
    Route::get('/admin/data-terapis',[TerapisAdminController::class,'index'])->name('data.terapis');
    Route::get('/admin/pendaftaran-terapis',[PendaftaranTerapisAdminController::class,'index'])->name('data.pendaftaran.terapis');
    Route::get('/admin/inbox',[InboxController::class,'index'])->name('inbox.index');
    Route::get('/admin/keahlian',[KeahlianAdminController::class,'index'])->name('data.keahlian');
    Route::get('/admin/data-terapis/datatables',[TerapisAdminController::class,'terapis_datatables'])->name('data-terapis.datatables');
    Route::get('/admin/promo', [PromoAdminController::class,'index'])->name('data.promo');
    Route::post('/admin/promo/store', [PromoAdminController::class,'store'])->name('data.promo.store');
    Route::get('admin/data-promo/datatables',[PromoAdminController::class,'data_promo_datatables'])->name('data-promo.datatables');
    Route::get('/admin/promo/{id}/edit', [PromoAdminController::class, 'edit']);
    Route::put('/admin/promo/{id}/update', [PromoAdminController::class, 'update']);
    Route::delete('/admin/promo/{id}/delete', [PromoAdminController::class, 'destroy']);

    Route::post('/webhook/fonnte/status',[FonnteWebhookController::class, 'status']);
    Route::get('/admin/whatsapp/logs',[AdminController::class, 'whatsappLogs'])->name('data.whatsapp.log');

    Route::resource('messages', MessageController::class);
    Route::resource('devices', DeviceController::class);

    Route::get('/heartbeat', [HeartbeatController::class, 'index']);

    Route::post('send-message', [DeviceController::class, 'sendMessage'])->name('send.message');
    Route::post('devices/status', [DeviceController::class, 'checkDeviceStatus']);
    Route::post('devices/activate', [DeviceController::class, 'activateDevice'])->name('devices.activate');
    Route::post('devices/disconnect', [DeviceController::class, 'disconnect'])->name('devices.disconnect');
});

Route::get('/jam-terpakai',[DashboardController::class,'jamTerpakai']);


Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::get('/therapist-dashboard', [TherapistController::class, 'index'])->name('therapist.dashboard');
});

Route::get('/register-therapist', [TherapistController::class, 'create'])->name('register.therapist');
Route::post('/register-therapist', [TherapistController::class, 'store'])->name('therapist.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile/detail',[ProfileController::class,'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/settings',[SettingProfilController::class,'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingProfilController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [SettingProfilController::class, 'destroy'])->name('settings.destroy');

});

Route::post('/track-visitor',[DashboardController::class,'trackVisitor'])->middleware(['track.visitor','throttle:10,1']);

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/get-keuntungan',[DashboardController::class,'jumlah_keuntungan']);
    Route::get('/get-count', [DashboardController::class, 'jumlah_notifikasi']);
    Route::get('/get-notifikasi', [DashboardController::class, 'get_notifikasi']);
    Route::get('/get-reservasi-count', [DashboardController::class, 'get_reservasi_count']);
    Route::get('/get-users-count', [DashboardController::class, 'get_users_count']);
    Route::get('/get-visitors-count',[DashboardController::class, 'get_visitor_count']);
    Route::post('/notifikasi/{id}/read',[DashboardController::class,'markAsRead']);
    Route::post('/notifikasi/read-all', [DashboardController::class, 'markAsReadAll']);
    Route::get('/realtime/active-users', [DashboardController::class, 'activeUsers'])
    ->name('admin.realtime.active-users');
    Route::post('/profile/photo', [SettingProfilController::class, 'updatePhoto'])
    ->name('profile.photo.update');
    Route::post('/profile/photo/select', [SettingProfilController::class, 'selectPhoto'])
    ->name('profile.photo.select');
    Route::delete('/profile/photo', [SettingProfilController::class, 'deletePhoto'])
    ->name('profile.photo.delete');
    Route::post('/profile/photo/delete', [SettingProfilController::class, 'deletePhoto'])
    ->name('profile.photo.delete.post');
    Route::post('/profile/background', [SettingProfilController::class, 'updateBackground'])
    ->name('profile.background.update');
});


require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Transaksi;
use App\Services\FonnteService;

class SendPaymentController extends Controller
{

    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    public function sendPaymentPage($id){

        $token = Device::where('is_activated',true)->value('token');
        $transaksi = Transaksi::select('transaksi.*', 'jenis_terapi.nama AS nama_jenis_terapi')
        ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->where('transaksi.id', $id)
        ->first();
            
            $data = [
            'target'=>$transaksi->nohp,
            'message' => "Halo, reservasi Anda untuk tanggal tersebut tersedia.\n\n"
    ."Silakan melanjutkan pembayaran agar jadwal dapat diproses dan diamankan.\n\n"
    ."Link pembayaran:\n"
    .route('show.payment.page',['id'=>$transaksi->id])
    ."\n\nTerima kasih."];

            // $data = [
            //     'target' => $transaksi->nohp,
            //     'message' => 'Reservasi tersedia. Silakan bayar: ' . route('show.payment.page', ['id'=>$transaksi->id])
            // ];
       
            $this->fonnteService->sendWhatsAppMessage(
            $data['target'],
            $data['message'],
            $token
            );

        // dd($response);
       
        return back();
    }
}

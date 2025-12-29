<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\WaToken;

class SendPaymentController extends Controller
{
    public function sendPaymentPage($id){

        $token = WaToken::where('active',true)->first();

        $transaksi = Transaksi::where('id',$id)->first();
        
        $pesan = [
            'target'=>$transaksi->nohp,
            'message'=>'
✅ *Reservasi Tersedia!* 🎉  
Kabar baik! Reservasi untuk hari tersebut *tersedia* 🗓✨  
Silakan lakukan pembayaran terlebih dahulu untuk mengamankan slot Anda. 🔒💳  

🔗 *Bayar Sekarang:* '.route('show.payment.page',['id'=>$transaksi->id]).'  

Terima kasih telah mempercayai layanan kami! 😊🙏 '];

        kirimPesan($token->token,$pesan);
        return back();
    }
}

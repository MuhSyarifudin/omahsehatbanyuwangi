<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Isset_;

class TransaksiController extends Controller
{ 
    public function index(){

    }

    public function checkout(Request $request){

        $key = $request->layanan == 'Homecare' ? 'alamat':'';
        $value = $request->layanan == 'Homecare' ? 'required|string|max:255':'';

        $request->validate([
            'nama_lengkap' => 'required|string|max:60',
            'nohp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'layanan' => 'required',
             $key => $value,
            'tanggal' => 'required',
            'hari' => 'required',
            'jam' => 'required',
            'terapi' => 'required',
            'jumlah' => 'required',
        ], [
            'nama_lengkap.required' => 'Tolong isi nama anda.',
            'nama_lengkap.string' => 'Nama harus berupa teks.',
            'nama_lengkap.max' => 'Nama tidak boleh lebih dari 60 karakter.',
            'nohp.required' => 'Tolong cantumkan nomor Whatsapp anda.',
            'nohp.numeric' => 'nomor Whatsapp harus berupa angka.',
            'jenis_kelamin.required' => 'Tolong pilih jenis kelamin.',
            'layanan.required' => 'Tolong pilih jenis layanan yang anda inginkan.',
            'alamat.required' => 'Tolong isi alamat tempat homecare.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'tanggal.required' => 'Mohon pilih tanggal reservasi.',
            'hari.required' => 'Tolong pilih hari terapi.',
            'jam.required' => 'Tolong pilih jam terapi.',
            'terapi.required' => 'Tolong pilih jenis Terapi yang anda inginkan.',
            'jumlah.required' => 'Tolong masukan jumlah orang yang diterapi.',
        ]);
        
            $terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first();
            $request->request->add(['total_harga'=>$request->jumlah * $terapi->harga]);
            // dd($request->all());
    
            $transaksi =  new Transaksi();
    
            $transaksi->nama = $request->nama_lengkap;
            $transaksi->nama_terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first()->nama;
            if (Isset($request->alamat)) {
                $transaksi->alamat = $request->alamat;
            }
            $transaksi->jenis_kelamin = $request->jenis_kelamin;
            $transaksi->nohp = $request->nohp;
            $transaksi->tempat = $request->layanan;
            $transaksi->tanggal = $request->tanggal;
            $transaksi->hari = $request->hari;
            $transaksi->jam = $request->jam;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->total_harga = $request->total_harga;
            $transaksi->save();
    
            $harga_terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first()->harga;

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;
    
            $params = array(
                'transaction_details' => array(
                    'order_id' => 'ORDER_' . time(),
                    'id' => $transaksi->id,
                    'gross_amount' => $transaksi->total_harga,
                ),
                'customer_details' => array(
                    'nama' => $transaksi->nama,
                    'phone' => $transaksi->nohp,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            session()->put('transaksi',$transaksi);
            session()->put('snapToken',$snapToken);
            session()->put('harga_terapi',$harga_terapi);
            
            return redirect()->route('detail.reservasi.terapi');
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512",$request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == "capture") {
                $transaksi = Transaksi::find($request->id);
                    $transaksi->update(['status' => 'Paid']);
                    
            }
        }
    }
    
}

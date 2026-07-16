<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Events\NotifikasiReservasiEvent;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout(StoreReservationRequest $request){

        $request->validated();

        if ($request->filled('website')) {
            abort(403);
        }
        
        $terapi = DB::table('layanan_terapi')
        ->where('id', $request->terapi)
        ->first();

        $transaksi = DB::transaction(function () use ($request,$terapi) {

            do {
                $reservationId =
                    'RSV-' .Str::upper(Str::ulid());

            } while (Transaksi::where('order_id', $reservationId)->exists());

            $invoice_token = Str::random(64);

            $totalHarga = $request->jumlah * $terapi->harga;

            $trx =  new Transaksi();

            $trx->nama = $request->nama_lengkap;
            $trx->nama_terapi =$terapi->nama;
            $trx->alamat = $request->alamat ?? null;
            $trx->jenis_kelamin = $request->jenis_kelamin;
            $trx->nohp = $request->nohp;
            $trx->tempat = $request->layanan;
            $trx->tanggal = $request->tanggal;
            $trx->hari = $request->hari;
            $trx->jam = $request->jam;
            $trx->jumlah = $request->jumlah;
            $trx->total_harga = $totalHarga;
            $trx->terapi_id = $terapi->id;
            $trx->order_id = $reservationId;
            $trx->invoice_token = $invoice_token;
            $trx->save();
        
            return $trx;
        });

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
                'order_id' => $transaksi->order_id,
                'gross_amount' => $transaksi->total_harga,
            ),
            'customer_details' => array(
                'nama' => $transaksi->nama,
                'phone' => $transaksi->nohp,
            ),
            'callbacks' => [
                'finish' => route('invoice.index',['order_id'=>$transaksi->order_id,'token'=>$transaksi->invoice_token]),
            ],
            'custom_field1' => $transaksi->id,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        $transaksi->update([
        'snap_token' => $snapToken
        ]);

        session()->put('transaksi',$transaksi);
        session()->put('snapToken',$snapToken);
        session()->put('harga_terapi',$harga_terapi);
    
        event(new NotifikasiReservasiEvent($transaksi));

        if ($transaksi->tempat == "center") {

            return redirect()->route('detail.reservasi.terapi');

        } else if ($transaksi->tempat == "homecare"){

            return redirect()->route('waiting.page');

        }
    }
}

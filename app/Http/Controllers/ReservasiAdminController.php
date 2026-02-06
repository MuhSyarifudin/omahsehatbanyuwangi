<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Akaunting\Money\Money;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservasiAdminController extends Controller
{
    public function data_reservasi(){

        return view('admin.data-reservasi');
    }

    public function data_reservasi_datatables(Request $request)
{
    $query = Transaksi::select(
        'transaksi.*',
        'layanan_terapi.nama as nama_layanan',
        'jenis_terapi.nama as nama_jenis_terapi'
    )
    ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
    ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id');

if ($request->bulan) {
    $query->whereMonth('transaksi.created_at', $request->bulan);
}
if ($request->tahun) {
    $query->whereYear('transaksi.created_at', $request->tahun);
}

return DataTables::of($query)
->addIndexColumn()

->addColumn('status_badge', function ($row) {

    $color = match ($row->status) {
        'pending'  => 'bg-orange-500',
        'paid'     => 'bg-green-500',
        'canceled' => 'bg-red-500',
        default    => 'bg-gray-500',
    };

    return '<span class="'.$color.' px-1.5 py-0.5 rounded-md text-white capitalize">'
            .$row->status.
           '</span>';
})

->addColumn('tanggal', function ($row) {
    return dateid('l, j F Y', strtotime($row->created_at));
})

->addColumn('aksi', function ($row) {

    return '
        <a
            class="openModal bg-primary hover:bg-opacity-90 px-2 py-1 text-gray-100 rounded-md cursor-pointer hover:cursor-pointer"
            data-id="'.$row->id.'">
            View Details
        </a>';
})

->rawColumns(['status_badge', 'aksi'])
->make(true);

}

public function data_reservasi_detail($id)
{
    $data = Transaksi::select(
            'transaksi.*',
            'layanan_terapi.nama as nama_layanan',
            'jenis_terapi.nama as nama_jenis_terapi'
        )
        ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->where('transaksi.id', $id)
        ->firstOrFail();

    return response()->json([
        'id' => $data->id,
        'nama' => $data->nama,
        'nohp' => $data->nohp,
        'jenis_kelamin' => $data->jenis_kelamin,
        'tempat' => $data->tempat,
        'alamat' => $data->alamat,
        'tanggal_booking'=> dateid('l, j F Y',strtotime($data->created_at)),
        'jam_booking'=> $data->created_at->format('H:i'),
        'tanggal_reservasi' => dateid('l, j F Y', strtotime($data->tanggal)),
        'jam_reservasi' => $data->jam,
        'terapi' => $data->nama_jenis_terapi.' - '.$data->nama_layanan,
        'jumlah' => $data->jumlah,
        'total' => (string) Money::IDR($data->total_harga, true),
        'status'=>$data->status,
        'payment_url' => route('send.payment.page', ['id' => $data->id])
    ]);
}

}

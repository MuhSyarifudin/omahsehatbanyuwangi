<?php

namespace App\Http\Controllers;

use Akaunting\Money\Money;
use App\Models\JenisTerapi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LayananTerapiAdminController extends Controller
{
    public function data_layanan(){

        $jenisTerapi = JenisTerapi::select('id','nama')->get();

        return view('admin.data-layanan',compact('jenisTerapi'));
    }

    public function data_layanan_datatables(){
        $query = DB::table('layanan_terapi')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->select('layanan_terapi.*', 'jenis_terapi.nama AS jenis')
        ->get();    

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('aksi',function($row){
            return '
            <a 
            data-id="'.$row->id.'"
            data-nama="'.$row->nama.'"
            data-jenis="'.$row->jenis_terapi.'"
            data-harga="'.$row->harga.'"
            class="btnEditLayanan bg-blue-600 cursor-pointer hover:bg-opacity-90 px-2 py-1 text-gray-100 rounded-lg">
            Edit
            </a>

            <a 
            data-id="'.$row->id.'"
            data-nama="'.$row->nama.'"
            class="btnDeleteLayanan bg-red-600 cursor-pointer hover:bg-opacity-90 px-2 py-1 ml-2 text-gray-100 rounded-lg">
            Hapus
            </a>
            ';
        })
        ->addColumn('harga',function($row){
            return rupiah((int) $row->harga ?? 0);
        })
        ->rawColumns(['aksi','harga'])
        ->make(true);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenis' => 'required',
            'harga' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $nama = $request->nama;
        $jenisTerapi = $request->jenis;
        $harga = $request->harga;

        $layanan = new Layanan();

        $layanan->nama = $nama;
        $layanan->jenis_terapi = $jenisTerapi;
        $layanan->harga = $harga;
        $layanan->save();

        return response()->json([
            'status'  => true,
            'message' => 'Data layanan berhasil disimpan',
            'data'    => $layanan,
        ],201);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'jenis_terapi'  => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $layanan = Layanan::findOrFail($id);

        $layanan->update([
            'nama'         => $request->nama,
            'jenis_terapi' => $request->jenis_terapi,
            'harga'        => $request->harga,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data layanan berhasil diperbarui',
            'data'    => $layanan,
        ]);
    }

    public function destroy($id){
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data layanan berhasil dihapus',
        ]);
    }

}

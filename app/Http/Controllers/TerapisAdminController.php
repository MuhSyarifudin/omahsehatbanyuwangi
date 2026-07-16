<?php

namespace App\Http\Controllers;

use App\Models\Terapis;
use Yajra\DataTables\Facades\DataTables;

class TerapisAdminController extends Controller
{
    public function index(){
        return view('admin.data-terapis');
    }

    public function terapis_datatables(){
        $query = Terapis::all();

        return DataTables::of($query)
        ->addIndexColumn('')
        ->addColumn('aksi',function($row){
            return '
            <a 
            data-id="'.$row->id.'"
            data-nama="'.$row->nama.'"
            data-alamat="'.$row->alamat.'"
            data-keahlian="'.$row->keahlian.'"
            data-email="'.$row->email.'"
            data-nohp="'.$row->nohp.'"
            class="btnEditTerapis bg-yellow-500 cursor-pointer hover:bg-opacity-90 px-1 py-1 mr-2 text-gray-100 rounded-lg">
            <i class="fa-solid fa-pen"></i>
            </a>

            <a 
            data-id="'.$row->id.'"
            data-nama="'.$row->nama.'"
            class="btnDeleteTerapis bg-red-600 cursor-pointer hover:bg-opacity-90 px-1 py-1 mr-2 text-gray-100 rounded-lg">
            <i class="fa-regular fa-trash-can"></i>
            </a>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
}

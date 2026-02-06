<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersAdminController extends Controller
{
    public function data_users(){

        return view('admin.data-users');
    }

    public function data_users_datatables(){
        $query = User::all();
        
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('verified',function($row){
            $status = $row->email_verified_at;

            if ($status) {
                return '<span class=" 
                bg-green-600 px-1.5 py-0.5 rounded-lg text-gray-100">
                    Sudah
                </span>';
            } else {
                return '<span class=" 
                bg-gray-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                    Belum
                </span>';
            };
        })
        ->addColumn('aksi',function($row){
            return '
            <a class="bg-primary cursor-pointer hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">View Details</a>
            ';})
        ->rawColumns(['aksi','verified'])
        ->make(true);
    }
}

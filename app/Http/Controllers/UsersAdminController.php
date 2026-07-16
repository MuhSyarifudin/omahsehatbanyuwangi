<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                bg-green-200 text-green-600 px-2 py-1 text-xs rounded uppercase">
                    Sudah
                </span>';
            } else {
                return '<span class=" 
                bg-neutral-200 text-neutral-600 px-2 py-1 text-xs rounded uppercase">
                    Belum
                </span>';
            };
        })
        ->addColumn('aksi',function($row){
            return '
            <a data-id="'.$row->id.'" class="btn-detail bg-primary cursor-pointer hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">View Details</a>
            ';})
        ->rawColumns(['aksi','verified'])
        ->make(true);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => ucfirst($user->role),
            'email_verified_at' => $user->email_verified_at,
            'created_at' => dateid('l, j F Y H:m:i',$user->created_at->format('d M Y H:i')),
            'updated_at' => dateid('l, j F Y H:m:i',$user->updated_at->format('d M Y H:i')),
        ]);
    }
}

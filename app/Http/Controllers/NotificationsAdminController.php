<?php

namespace App\Http\Controllers;

use App\Livewire\Notifikasi;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NotificationsAdminController extends Controller
{
    public function data_notifikasi(){
        

        return view('admin.data-notifikasi');
    }

    public function data_notifikasi_datatables(){
        $user = Auth::user()->id;

        $query = Notification::where('notifiable_id','=',$user)->get();

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('message',function($row){
            $data = json_decode($row->data,true);
            return $data['message'].'<br>'.$data['status'];
        })
        ->addColumn('waktu',function($row){
            return dateid('l, j F Y H:i',strtotime($row->created_at));
        })
        ->addColumn('status',function($row){
            $status = $row->read_at != null ? 'Dibaca' : 'Belum Dibaca';
            return $status;
        })
        ->addColumn('aksi',function($row){
            
            if ($row->read_at) {
                return '<a
                disabled="disabled"
                class="btn-mark-as-read bg-gray-400 cursor-pointer hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">
                 Sudah Dibaca
                </a>';
            }
            
            return '
            <a href="javascript:void(0)"
                   data-id="' . $row->getKey() . '"
                   class="btn-mark-as-read bg-primary cursor-pointer hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">
                    Tandai Dibaca
                </a>';
        })
        ->rawColumns(['message','waktu','status','aksi'])
        ->make(true);
    }

    public function markAsRead(Request $request,$id){
        $user = $request->user();

        $notification = $user->notifications()->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['message'=>'berhasil mengubah data'],200);
    }


}

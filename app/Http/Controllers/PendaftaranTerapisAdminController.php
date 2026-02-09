<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranTerapisAdminController extends Controller
{
    public function index(){
        return view('admin.data-pendaftaran-terapis');
    }
}

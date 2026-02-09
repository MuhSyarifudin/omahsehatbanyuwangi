<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TerapisAdminController extends Controller
{
    public function index(){
        return view('admin.data-terapis');
    }
}

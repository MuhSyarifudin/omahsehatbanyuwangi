<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeahlianAdminController extends Controller
{
    public function index(){
        return view('admin.data-keahlian');
    }
}

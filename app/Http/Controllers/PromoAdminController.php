<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoAdminController extends Controller
{
    public function index(){
        return view('admin.data-promo');
    }
}

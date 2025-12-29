<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentPageController extends Controller
{
    public function success(){
        return view('payment.success',['marginBottom'=>true]);
    }

    public function failed(){
        return view('payment.failed',['marginBottom'=>true]);
    }
}

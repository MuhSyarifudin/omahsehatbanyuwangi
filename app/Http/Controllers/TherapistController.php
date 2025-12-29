<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keahlian;
use App\Models\Terapis;

class TherapistController extends Controller
{
    public function index(){
        return view('therapist.dashboard');
    }

    public function create(){

        $keahlian = Keahlian::all();

        return view('therapist.registrasi',['marginBottom'=>true],compact('keahlian'));
    }

    public function store(Request $request){

        Terapis::create([
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'keahlian'=>$request->keahlian,
            'email'=>$request->email,
            'nohp'=>$request->whatsapp
        ]);

        return back();
    }
}

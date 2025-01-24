<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TerapiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('layanan_terapi')->truncate();

        $daftar_layanan = [


            //Terapi Bekam
            ['nama'=>'Detox','jenis_terapi'=>'1','harga'=>'250000'],
            ['nama'=>'Punggung','jenis_terapi'=>'1','harga'=>'100000'],
            ['nama'=>'Kepala','jenis_terapi'=>'1','harga'=>'100000'],
            ['nama'=>'Estetika','jenis_terapi'=>'1','harga'=>'100000'],

            //Terapi Kecantikan
            ['nama'=>'Totok Wajah','jenis_terapi'=>'2','harga'=>'150000'],
            ['nama'=>'Facial Detox','jenis_terapi'=>'2','harga'=>'200000'],
            ['nama'=>'Facial Electric','jenis_terapi'=>'2','harga'=>'200000'],
            ['nama'=>'Kendedes (SPA)','jenis_terapi'=>'2','harga'=>'250000'],
            ['nama'=>'Jasmine (SPA)','jenis_terapi'=>'2','harga'=>'250000'],
            ['nama'=>'Spa Telinga','jenis_terapi'=>'2','harga'=>'50000'],
            ['nama'=>'Sauna Rempah','jenis_terapi'=>'2','harga'=>'100000'],
            ['nama'=>'Terapi Mata','jenis_terapi'=>'2','harga'=>'100000'],

            //Terapi Akupuntur
            ['nama'=>'Keluhan','jenis_terapi'=>'3','harga'=>'200000'],
            ['nama'=>'Estetika Glowing','jenis_terapi'=>'3','harga'=>'200000'],
            ['nama'=>'Estetika Pelangsing','jenis_terapi'=>'3','harga'=>'200000'],
            ['nama'=>'Anti Double Chin','jenis_terapi'=>'3','harga'=>'200000'],
            ['nama'=>'Tuina Chuzen','jenis_terapi'=>'3','harga'=>'100000'],
            ['nama'=>'Aura','jenis_terapi'=>'3','harga'=>'100000'],
            ['nama'=>'Kebutuhan Khusus','jenis_terapi'=>'3','harga'=>''],
            
            //Perawatan Luka
            ['nama'=>'Diabetes','jenis_terapi'=>'4','harga'=>''],
            ['nama'=>'Vitamin Booster','jenis_terapi'=>'4','harga'=>''],
            
            //Cek Kesehatan
            ['nama'=>'Asam Urat','jenis_terapi'=>'5','harga'=>'10000'],
            ['nama'=>'Kolesterol','jenis_terapi'=>'5','harga'=>'25000'],
            ['nama'=>'Gula','jenis_terapi'=>'5','harga'=>'10000'],
            
            //Add On
            ['nama'=>'Collon Cleansing','jenis_terapi'=>'6','harga'=>'300000'],
            ['nama'=>'Rawat Sendi & Tulang','jenis_terapi'=>'6','harga'=>'150000'],
            ['nama'=>'Collon Cleansing','jenis_terapi'=>'6','harga'=>'100000'],
            ['nama'=>'THT (Gurah)','jenis_terapi'=>'6','harga'=>'100000'],
            ['nama'=>'Mata (Gurah)','jenis_terapi'=>'6','harga'=>'100000'],
            ['nama'=>'Terapi Lintah','jenis_terapi'=>'6','harga'=>'100000'],
        ];

        foreach ($daftar_layanan as $dl) {
            Layanan::create($dl);
        };


    }
}

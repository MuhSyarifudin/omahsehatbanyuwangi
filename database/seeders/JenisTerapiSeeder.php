<?php

namespace Database\Seeders;

use App\Models\JenisTerapi;
use App\Models\layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTerapiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('jenis_terapi')->truncate();

        $jenis_terapi = [
            ['nama'=>'Terapi Bekam'],
            ['nama'=>'Terapi Kecantikan'],
            ['nama'=>'Terapi Akupuntur'],
            ['nama'=>'Rawat Luka'],
            ['nama'=>'Cek Kesehatan'],
            ['nama'=>'Add On']
        ];

        foreach ($jenis_terapi as $jt) {
            JenisTerapi::create($jt);
        };
    }
}

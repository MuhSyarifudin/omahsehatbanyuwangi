<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Keahlian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('keahlian')->truncate();

        $keahlian = [
            ['nama'=>'Pijat'],
            ['nama'=>'Bekam'],
            ['nama'=>'Akupuntur'],
            ['nama'=>'Hypnosis']
        ];

            
        foreach ($keahlian as $kl) {
            Keahlian::create($kl);
        }
                
    }
}

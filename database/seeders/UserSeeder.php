<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        $daftar_user = [
                ['name'=>'Niken Kurnia Ningrum','email'=>'nikenkurnia@gmail.com','password'=>Hash::make('12345678'),'role'=>'admin'],
                ['name'=>'Muahamad Syarifudin Abdul Jalal','email'=>'suicideudin@gmail.com','password'=>Hash::make('12345678'),'role'=>'admin'],
                ['name'=>'Anugerah Bimasakti','email'=>'anugerah27@gmail.com','password'=>Hash::make('12345678'),'role'=>'admin']
        ];

        foreach ($daftar_user as $du) {
            User::create($du);
        };
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerbitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penerbit')->insert([
            ['kode_penerbit' => 'PNB001', 'nama_penerbit' => 'Darul Fikr', 'alamat' => 'Beirut, Lebanon', 'no_telepon' => '123456789', 'email' => 'info@darulfikr.com'],
            ['kode_penerbit' => 'PNB002', 'nama_penerbit' => 'Darussalam', 'alamat' => 'Riyadh, Saudi Arabia', 'no_telepon' => '987654321', 'email' => 'info@darussalam.com'],
            ['kode_penerbit' => 'PNB003', 'nama_penerbit' => 'Pustaka Al-Kautsar', 'alamat' => 'Jakarta, Indonesia', 'no_telepon' => '555123456', 'email' => 'info@pustakaalkautsar.com'],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            ['kode_pelanggan' => 'PLG001', 'nama_pelanggan' => 'Budi Santoso', 'alamat' => 'Jl. Pesantren No.1', 'no_telepon' => '081234567890', 'email' => 'budi@santri.com'],
            ['kode_pelanggan' => 'PLG002', 'nama_pelanggan' => 'Ahmad Fauzi', 'alamat' => 'Jl. Masjid No.5', 'no_telepon' => '081234567891', 'email' => 'ahmad@santri.com'],
            ['kode_pelanggan' => 'PLG003', 'nama_pelanggan' => 'Siti Aminah', 'alamat' => 'Jl. Madrasah No.3', 'no_telepon' => '081234567892', 'email' => 'siti@santri.com'],
        ]);
    }
}
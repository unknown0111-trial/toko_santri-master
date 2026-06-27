<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('supplier')->insert([
            ['kode_supplier' => 'SUP001', 'nama_supplier' => 'PT. Kitab Nusantara', 'alamat' => 'Jakarta', 'no_telepon' => '0211234567', 'email' => 'sales@kitabnusantara.com', 'kontak_person' => 'Budi'],
            ['kode_supplier' => 'SUP002', 'nama_supplier' => 'CV. Pustaka Ilmu', 'alamat' => 'Surabaya', 'no_telepon' => '0319876543', 'email' => 'info@pustakailmu.com', 'kontak_person' => 'Ani'],
            ['kode_supplier' => 'SUP003', 'nama_supplier' => 'UD. Buku Islam', 'alamat' => 'Bandung', 'no_telepon' => '0225556789', 'email' => 'order@bukuislam.com', 'kontak_person' => 'Caca'],
        ]);
    }
}
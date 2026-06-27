<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KitabSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kitab')->insert([
            [
                'kode_kitab' => 'KTB001',
                'judul_kitab' => 'Al-Umm',
                'kategori_id' => 1, // Fiqih
                'pengarang_id' => 3, // Imam Syafi'i
                'penerbit_id' => 1, // Darul Fikr
                'supplier_id' => 1,
                'stok' => 10,
                'stok_minimal' => 2,
                'harga_beli' => 150000,
                'harga_jual' => 200000,
                'status' => 'aktif'
            ],
            [
                'kode_kitab' => 'KTB002',
                'judul_kitab' => 'Ihya Ulumuddin',
                'kategori_id' => 3, // Tasawuf
                'pengarang_id' => 5, // Imam Al-Ghazali
                'penerbit_id' => 2, // Darussalam
                'supplier_id' => 2,
                'stok' => 8,
                'stok_minimal' => 2,
                'harga_beli' => 120000,
                'harga_jual' => 175000,
                'status' => 'aktif'
            ],
            [
                'kode_kitab' => 'KTB003',
                'judul_kitab' => 'Tafsir Ibnu Katsir',
                'kategori_id' => 4, // Tafsir
                'pengarang_id' => 6, // Ibnu Katsir
                'penerbit_id' => 1, // Darul Fikr
                'supplier_id' => 1,
                'stok' => 5,
                'stok_minimal' => 1,
                'harga_beli' => 250000,
                'harga_jual' => 350000,
                'status' => 'aktif'
            ],
        ]);
    }
}
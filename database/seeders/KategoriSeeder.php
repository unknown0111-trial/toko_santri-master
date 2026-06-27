<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['kode_kategori' => 'KAT001', 'nama_kategori' => 'Fiqih', 'bidang_ilmu' => 'Fiqih', 'deskripsi' => 'Kitab-kitab tentang fiqih Islam'],
            ['kode_kategori' => 'KAT002', 'nama_kategori' => 'Tauhid', 'bidang_ilmu' => 'Aqidah', 'deskripsi' => 'Kitab-kitab tentang tauhid dan aqidah'],
            ['kode_kategori' => 'KAT003', 'nama_kategori' => 'Tasawuf', 'bidang_ilmu' => 'Tasawuf', 'deskripsi' => 'Kitab-kitab tentang tasawuf dan akhlak'],
            ['kode_kategori' => 'KAT004', 'nama_kategori' => 'Tafsir', 'bidang_ilmu' => 'Tafsir', 'deskripsi' => 'Kitab-kitab tafsir Al-Quran'],
            ['kode_kategori' => 'KAT005', 'nama_kategori' => 'Hadits', 'bidang_ilmu' => 'Hadits', 'deskripsi' => 'Kitab-kitab tentang hadits'],
            ['kode_kategori' => 'KAT006', 'nama_kategori' => 'Bahasa Arab', 'bidang_ilmu' => 'Lughoh', 'deskripsi' => 'Kitab-kitab tentang bahasa Arab'],
            ['kode_kategori' => 'KAT007', 'nama_kategori' => 'Sejarah Islam', 'bidang_ilmu' => 'Tarikh', 'deskripsi' => 'Kitab-kitab tentang sejarah Islam'],
        ]);
    }
}
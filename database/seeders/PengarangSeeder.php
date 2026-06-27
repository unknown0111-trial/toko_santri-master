<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengarang')->insert([
            ['kode_pengarang' => 'PGR001', 'nama_pengarang' => 'Imam Abu Hanifah', 'biografi' => 'Pendiri mazhab Hanafi', 'negara_asal' => 'Irak'],
            ['kode_pengarang' => 'PGR002', 'nama_pengarang' => 'Imam Malik', 'biografi' => 'Pendiri mazhab Maliki', 'negara_asal' => 'Madinah'],
            ['kode_pengarang' => 'PGR003', 'nama_pengarang' => 'Imam Syafi\'i', 'biografi' => 'Pendiri mazhab Syafi\'i', 'negara_asal' => 'Palestina'],
            ['kode_pengarang' => 'PGR004', 'nama_pengarang' => 'Imam Ahmad bin Hanbal', 'biografi' => 'Pendiri mazhab Hanbali', 'negara_asal' => 'Baghdad'],
            ['kode_pengarang' => 'PGR005', 'nama_pengarang' => 'Imam Al-Ghazali', 'biografi' => 'Ulama besar dalam tasawuf', 'negara_asal' => 'Persia'],
            ['kode_pengarang' => 'PGR006', 'nama_pengarang' => 'Ibnu Katsir', 'biografi' => 'Ahli tafsir dan sejarah', 'negara_asal' => 'Suriah'],
        ]);
    }
}
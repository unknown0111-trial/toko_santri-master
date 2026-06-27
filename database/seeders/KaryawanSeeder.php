<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('karyawan')->insert([
            [
                'nik' => '20240001',
                'nama' => 'Ahmad Fauzan',
                'jabatan' => 'Manager',
                'departemen' => 'Manajemen',
                'alamat' => 'Jl. Pesantren No. 1, Malang',
                'no_telepon' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_masuk' => '2024-01-15',
                'gaji' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '20240002',
                'nama' => 'Siti Aisyah',
                'jabatan' => 'Kasir',
                'departemen' => 'Penjualan',
                'alamat' => 'Jl. Masjid No. 5, Malang',
                'no_telepon' => '081234567891',
                'jenis_kelamin' => 'P',
                'tanggal_masuk' => '2024-02-01',
                'gaji' => 3500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '20240003',
                'nama' => 'Muhammad Rizki',
                'jabatan' => 'Staff Gudang',
                'departemen' => 'Logistik',
                'alamat' => 'Jl. Candi No. 10, Malang',
                'no_telepon' => '081234567892',
                'jenis_kelamin' => 'L',
                'tanggal_masuk' => '2024-02-15',
                'gaji' => 3000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '20240004',
                'nama' => 'Fatimah Zahra',
                'jabatan' => 'Administrasi',
                'departemen' => 'Administrasi',
                'alamat' => 'Jl. Sultan Agung No. 20, Malang',
                'no_telepon' => '081234567893',
                'jenis_kelamin' => 'P',
                'tanggal_masuk' => '2024-03-01',
                'gaji' => 3800000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '20240005',
                'nama' => 'Abdul Malik',
                'jabatan' => 'Sales',
                'departemen' => 'Pemasaran',
                'alamat' => 'Jl. Borobudur No. 15, Malang',
                'no_telepon' => '081234567894',
                'jenis_kelamin' => 'L',
                'tanggal_masuk' => '2024-03-10',
                'gaji' => 4000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanModel extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'karyawan_id';
    protected $fillable = [
        'nik', 'nama', 'jabatan', 'departemen', 'alamat', 
        'no_telepon', 'jenis_kelamin', 'tanggal_masuk', 'gaji'
    ];
}
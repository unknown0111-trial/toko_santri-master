<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    protected $fillable = [
        'kode_pelanggan', 'nama_pelanggan', 'alamat', 'no_telepon', 'email'
    ];

    public function penjualan()
    {
        return $this->hasMany(PenjualanModel::class, 'pelanggan_id', 'pelanggan_id');
    }
}
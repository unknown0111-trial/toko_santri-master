<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = [
        'kode_penjualan', 'user_id', 'pelanggan_id', 'tanggal_penjualan',
        'subtotal', 'diskon', 'total', 'bayar', 'kembalian', 'status', 'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(KaryawanModel::class, 'user_id', 'karyawan_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, 'pelanggan_id', 'pelanggan_id');
    }

    public function detail()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }
}
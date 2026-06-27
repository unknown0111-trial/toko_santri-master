<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';
    protected $fillable = [
        'kode_pembelian', 'supplier_id', 'user_id', 
        'tanggal_pembelian', 'total_harga', 'status', 'keterangan'
    ];

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(KaryawanModel::class, 'user_id', 'karyawan_id');
    }

    public function detail()
    {
        return $this->hasMany(PembelianDetailModel::class, 'pembelian_id', 'pembelian_id');
    }
}
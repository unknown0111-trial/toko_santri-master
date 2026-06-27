<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['kode_supplier', 'nama_supplier', 'alamat', 'no_telepon', 'email', 'kontak_person'];

    // Relasi ke pembelian
    public function pembelian()
    {
        return $this->hasMany(PembelianModel::class, 'supplier_id', 'supplier_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetailModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['pembelian_id', 'kitab_id', 'jumlah', 'harga_beli', 'subtotal'];

    public function pembelian()
    {
        return $this->belongsTo(PembelianModel::class, 'pembelian_id', 'pembelian_id');
    }

    public function kitab()
    {
        return $this->belongsTo(KitabModel::class, 'kitab_id', 'kitab_id');
    }
}
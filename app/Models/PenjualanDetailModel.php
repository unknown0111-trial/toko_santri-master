<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetailModel extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['penjualan_id', 'kitab_id', 'jumlah', 'harga_jual', 'subtotal'];

    public function penjualan()
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }

    public function kitab()
    {
        return $this->belongsTo(KitabModel::class, 'kitab_id', 'kitab_id');
    }
}
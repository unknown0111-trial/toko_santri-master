<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'kategori_id';
    protected $fillable = ['kode_kategori', 'nama_kategori', 'bidang_ilmu', 'deskripsi'];

    // Relasi ke kitab
    public function kitab()
    {
        return $this->hasMany(KitabModel::class, 'kategori_id', 'kategori_id');
    }
}
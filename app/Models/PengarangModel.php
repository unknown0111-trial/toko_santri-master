<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengarangModel extends Model
{
    use HasFactory;

    protected $table = 'pengarang';
    protected $primaryKey = 'pengarang_id';
    protected $fillable = ['kode_pengarang', 'nama_pengarang', 'biografi', 'negara_asal'];

    // Relasi ke kitab
    public function kitab()
    {
        return $this->hasMany(KitabModel::class, 'pengarang_id', 'pengarang_id');
    }
}
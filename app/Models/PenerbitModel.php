<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerbitModel extends Model
{
    use HasFactory;

    protected $table = 'penerbit';
    protected $primaryKey = 'penerbit_id';
    protected $fillable = ['kode_penerbit', 'nama_penerbit', 'alamat', 'no_telepon', 'email'];

    // Relasi ke kitab
    public function kitab()
    {
        return $this->hasMany(KitabModel::class, 'penerbit_id', 'penerbit_id');
    }
}
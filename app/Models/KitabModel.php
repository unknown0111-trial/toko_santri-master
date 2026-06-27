<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitabModel extends Model
{
    use HasFactory;

    protected $table = 'kitab';
    protected $primaryKey = 'kitab_id';
    protected $fillable = [
        'kode_kitab', 'judul_kitab', 'isbn',
        'kategori_id', 'pengarang_id', 'penerbit_id', 'supplier_id',
        'tahun_terbit', 'tebal_buku', 'bahasa', 'deskripsi', 'cover_image', 'sinopsis',
        'stok', 'stok_minimal', 'harga_beli', 'harga_jual', 'diskon', 'status'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    // Relasi ke Pengarang
    public function pengarang()
    {
        return $this->belongsTo(PengarangModel::class, 'pengarang_id', 'pengarang_id');
    }

    // Relasi ke Penerbit
    public function penerbit()
    {
        return $this->belongsTo(PenerbitModel::class, 'penerbit_id', 'penerbit_id');
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }

    // Accessor untuk format harga
    public function getHargaJualFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    public function getHargaBeliFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    // Update stok saat pembelian
    public function tambahStok($jumlah)
    {
        $this->stok += $jumlah;
        $this->save();
    }

    // Kurangi stok saat penjualan
    public function kurangiStok($jumlah)
    {
        if ($this->stok >= $jumlah) {
            $this->stok -= $jumlah;
            $this->save();
            return true;
        }
        return false;
    }
}
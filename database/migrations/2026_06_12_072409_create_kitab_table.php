<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kitab', function (Blueprint $table) {
            $table->id('kitab_id');
            $table->string('kode_kitab', 20)->unique();
            $table->string('judul_kitab', 200);
            $table->string('isbn', 20)->nullable();
            
            // Foreign Keys
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('pengarang_id');
            $table->unsignedBigInteger('penerbit_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            
            // Detail Kitab
            $table->integer('tahun_terbit')->nullable();
            $table->integer('tebal_buku')->nullable(); // jumlah halaman
            $table->string('bahasa', 50)->default('Arab');
            $table->text('deskripsi')->nullable();
            $table->string('cover_image')->nullable(); // foto cover kitab
            $table->string('sinopsis', 500)->nullable();
            
            // Stok & Harga
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(5); // batas minimal stok
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->decimal('diskon', 5, 2)->default(0); // diskon dalam persen
            
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Foreign Key Constraints
            $table->foreign('kategori_id')->references('kategori_id')->on('kategori');
            $table->foreign('pengarang_id')->references('pengarang_id')->on('pengarang');
            $table->foreign('penerbit_id')->references('penerbit_id')->on('penerbit');
            $table->foreign('supplier_id')->references('supplier_id')->on('supplier');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitab');
    }
};
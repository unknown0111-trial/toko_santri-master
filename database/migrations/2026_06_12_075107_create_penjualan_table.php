<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->string('kode_penjualan', 20)->unique();
            $table->unsignedBigInteger('user_id'); // kasir yang melayani
            $table->unsignedBigInteger('pelanggan_id')->nullable(); // bisa guest atau pelanggan terdaftar
            $table->date('tanggal_penjualan');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('diskon', 5, 2)->default(0); // diskon dalam persen
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('bayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('selesai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('karyawan_id')->on('karyawan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
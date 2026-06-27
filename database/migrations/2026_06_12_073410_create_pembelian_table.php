<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('pembelian_id');
            $table->string('kode_pembelian', 20)->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id'); // user yang melakukan pembelian
            $table->date('tanggal_pembelian');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('supplier_id')->references('supplier_id')->on('supplier');
            $table->foreign('user_id')->references('user_id')->on('karyawan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
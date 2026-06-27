<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('penjualan_id');
            $table->unsignedBigInteger('kitab_id');
            $table->integer('jumlah');
            $table->decimal('harga_jual', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
            
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan')->onDelete('cascade');
            $table->foreign('kitab_id')->references('kitab_id')->on('kitab');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
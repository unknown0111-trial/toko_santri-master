<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengarang', function (Blueprint $table) {
            $table->id('pengarang_id');
            $table->string('kode_pengarang', 20)->unique();
            $table->string('nama_pengarang', 100);
            $table->string('biografi', 255)->nullable();
            $table->string('negara_asal', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengarang');
    }
};
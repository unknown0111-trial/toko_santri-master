<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerbit', function (Blueprint $table) {
            $table->id('penerbit_id');
            $table->string('kode_penerbit', 20)->unique();
            $table->string('nama_penerbit', 100);
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerbit');
    }
};
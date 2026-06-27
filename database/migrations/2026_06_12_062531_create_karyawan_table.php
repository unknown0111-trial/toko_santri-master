<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('karyawan_id');
            $table->string('nik', 20)->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            $table->string('departemen', 50);
            $table->string('alamat', 255);
            $table->string('no_telepon', 15);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_masuk');
            $table->integer('gaji');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
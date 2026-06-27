<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->string('kode_supplier', 20)->unique();
            $table->string('nama_supplier', 100);
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('kontak_person', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
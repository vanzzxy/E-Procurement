<?php

// database/migrations/2025_11_05_000002_create_dcr_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dcr', function (Blueprint $table) {
            $table->id('id_dcr');
            $table->string('kode_dcr')->unique();
            $table->string('nama_dcr');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dcr');
    }
};

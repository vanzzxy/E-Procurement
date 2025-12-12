<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('datakontrak', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel buatkontraks
            $table->foreignId('kontrak_id')
                ->constrained('buatkontrak')
                ->onDelete('cascade');

            // Data kontrak yang disalin
            $table->string('no_purchaseorder');
            $table->string('kategori_barang')->nullable();
            $table->string('vendor')->nullable();
            $table->integer('harga_total')->nullable();
            $table->date('deadline')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datakontrak');
    }
};

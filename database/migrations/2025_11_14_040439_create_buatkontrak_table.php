<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buatkontrak', function (Blueprint $table) {
            $table->id(); // pastikan ini ada
            $table->string('no_purchaseorder')->unique();
            $table->unsignedBigInteger('vendor_id');
            $table->string('kategori_barang');
            $table->timestamps();
            $table->foreign('vendor_id')->references('id_vendor')->on('vendor')->onDelete('cascade');
        });

        Schema::create('buatkontrak_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buatkontrak_id');
            $table->unsignedBigInteger('masterbarang_id');
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->foreign('buatkontrak_id')->references('id')->on('buatkontrak')->onDelete('cascade');
            $table->foreign('masterbarang_id')->references('id_masterbarang')->on('masterbarang')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('buatkontrak_barang');
        Schema::dropIfExists('buatkontrak');
    }
};

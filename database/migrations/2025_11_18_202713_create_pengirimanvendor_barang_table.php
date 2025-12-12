<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengirimanvendor_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengiriman_id');
            $table->unsignedBigInteger('buatkontrak_barang_id');
            $table->timestamps();

            $table->foreign('pengiriman_id')->references('id')->on('pengirimanvendor')->onDelete('cascade');
            $table->foreign('buatkontrak_barang_id')->references('id')->on('buatkontrak_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimanvendor_barang');
    }
};

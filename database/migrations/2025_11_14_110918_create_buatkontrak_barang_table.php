<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buatkontrak_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buatkontrak_id');
            $table->unsignedBigInteger('masterbarang_id');

            $table->foreign('buatkontrak_id')->references('id_buatkontrak')->on('buatkontrak')->onDelete('cascade');
            $table->foreign('masterbarang_id')->references('id_masterbarang')->on('masterbarang')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('buatkontrak_barang');
    }
};

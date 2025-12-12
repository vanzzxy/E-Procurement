<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengirimanvendor', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_jalan');
            $table->string('no_purchaseorder');
            $table->string('no_polisi');
            $table->string('nama_sopir');
            $table->string('telepon_sopir');
            $table->string('armada');
            $table->string('file_suratjalan')->nullable();

            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('kontrak_id');

            $table->timestamps();

            $table->foreign('vendor_id')->references('id_vendor')->on('vendor')->onDelete('cascade');
            $table->foreign('kontrak_id')->references('id')->on('buatkontrak')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimanvendor');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('masterbarang', function (Blueprint $table) {
            $table->unsignedBigInteger('masterklasifikasi_id')->nullable()->after('nama_barang');
            $table->foreign('masterklasifikasi_id')->references('id')->on('masterklasifikasi');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_barangs', function (Blueprint $table) {
            //
        });
    }
};

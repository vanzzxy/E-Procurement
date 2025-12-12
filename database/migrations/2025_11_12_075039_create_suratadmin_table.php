<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('suratadmin', function (Blueprint $table) {
            $table->bigIncrements('id_suratadmin');
            $table->unsignedBigInteger('id_vendor');
            $table->string('nama_perusahaan');
            $table->string('jenis_surat', 100);
            $table->text('deskripsi')->nullable();
            $table->string('file_surat');
            $table->timestamps();

            // Relasi ke tabel vendor
            $table->foreign('id_vendor')
                ->references('id_vendor')
                ->on('vendor')
                ->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('suratadmin');
    }
};

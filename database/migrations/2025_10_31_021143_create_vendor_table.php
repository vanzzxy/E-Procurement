<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->integer('id_vendor', true);
            $table->string('asal_perusahaan', 20);
            $table->string('npwp', 50)->nullable()->unique('npwp');
            $table->string('fax', 20)->nullable();
            $table->string('jenis_badan_usaha', 10)->nullable();
            $table->string('nama_perusahaan');
            $table->text('alamat_perusahaan');
            $table->string('email_perusahaan', 100)->unique('email_perusahaan');
            $table->string('telepon_perusahaan', 20);
            $table->text('kategori_perusahaan')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('file_iso')->nullable();
            $table->string('file_siup')->nullable();
            $table->string('file_skf')->nullable();
            $table->string('nama_lengkap1', 100)->nullable();
            $table->string('jabatan1', 100)->nullable();
            $table->string('email1', 100)->nullable();
            $table->string('telepon1', 20)->nullable();
            $table->string('nama_lengkap2', 100)->nullable();
            $table->string('jabatan2', 100)->nullable();
            $table->string('email2', 100)->nullable();
            $table->string('telepon2', 20)->nullable();
            $table->integer('id_user')->nullable()->index('id_user');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor');
    }
};

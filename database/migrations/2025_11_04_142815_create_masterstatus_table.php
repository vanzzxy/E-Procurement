<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_create_master_status_table.php
    // public function up()
    // {
    //     Schema::create('masterstatus', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('status')->nullable(); // tambahkan kolom status
    //         $table->string('keterangan_status')->nullable(); // tambahkan kolom keterangan_status
    //         // Pastikan unsigned dan tipe sama
    //         $table->unsignedBigInteger('id_klasifikasi');

    //         // Foreign key dengan nama tabel yang benar
    //         $table->foreign('id_klasifikasi')
    //             ->references('id_klasifikasi')
    //             ->on('masterklasifikasi') // ini harus sama dengan nama tabel di DB
    //             ->onDelete('cascade');

    //         $table->timestamps();
    //     });

    // }

    public function up(): void
    {
        if (! Schema::hasTable('masterstatus')) {
            Schema::create('masterstatus', function (Blueprint $table) {
                $table->id();
                $table->string('status')->nullable();
                $table->string('keterangan_status')->nullable();
                $table->unsignedBigInteger('id_klasifikasi');
                $table->timestamps();
            });
        }
    }
};

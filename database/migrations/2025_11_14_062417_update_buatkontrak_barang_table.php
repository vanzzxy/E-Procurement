<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            // Ganti nama kolom harga_total menjadi harga
            $table->renameColumn('harga_total', 'harga');

            // Hapus kolom deadline
            $table->dropColumn('deadline');
        });
    }

    public function down(): void
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            // Kembalikan perubahan jika rollback
            $table->bigInteger('harga_total')->nullable()->after('jumlah');
            $table->date('deadline')->nullable()->after('harga_total');

            // Hapus kolom harga
            $table->dropColumn('harga');
        });
    }
};

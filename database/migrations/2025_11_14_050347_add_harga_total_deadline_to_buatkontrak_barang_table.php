<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            // Hanya buat kolom yang belum ada
            if (! Schema::hasColumn('buatkontrak_barang', 'harga_total')) {
                $table->decimal('harga_total', 15, 2)->nullable()->after('jumlah');
            }

            if (! Schema::hasColumn('buatkontrak_barang', 'deadline')) {
                $table->date('deadline')->nullable()->after('harga_total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            if (Schema::hasColumn('buatkontrak_barang', 'harga_total')) {
                $table->dropColumn('harga_total');
            }

            if (Schema::hasColumn('buatkontrak_barang', 'deadline')) {
                $table->dropColumn('deadline');
            }
        });
    }
};

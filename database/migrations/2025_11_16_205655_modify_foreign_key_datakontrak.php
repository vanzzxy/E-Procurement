<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            // Hapus foreign key lama jika ada
            $table->dropForeign(['kontrak_id']);

            // Jika kolom kontrak_id belum nullable dan ingin pakai 'set null'
            $table->unsignedBigInteger('kontrak_id')->nullable()->change();

            // Tambahkan foreign key baru ke tabel buatkontrak
            $table->foreign('kontrak_id')
                ->references('id')->on('buatkontrak')
                ->onDelete('set null'); // atau 'restrict' jika ingin dicegah penghapusan
        });
    }

    public function down(): void
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            $table->dropForeign(['kontrak_id']);

            // Kembalikan kolom ke semula (opsional)
            $table->unsignedBigInteger('kontrak_id')->nullable(false)->change();
        });
    }
};

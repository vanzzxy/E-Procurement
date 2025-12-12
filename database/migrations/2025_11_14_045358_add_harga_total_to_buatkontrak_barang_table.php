<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            $table->bigInteger('harga_total')->nullable()->after('jumlah'); // harga awal null
        });
    }

    public function down()
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            $table->dropColumn('harga_total');
        });
    }
};

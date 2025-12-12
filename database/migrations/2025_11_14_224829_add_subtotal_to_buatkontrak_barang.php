<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            $table->bigInteger('subtotal')->default(0);
        });
    }

    public function down()
    {
        Schema::table('buatkontrak_barang', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};

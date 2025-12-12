<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPengirimanvendorTable extends Migration
{
    public function up()
    {
        Schema::table('pengirimanvendor', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'pengiriman', 'diterima', 'selesai'])
                ->default('pengiriman');
        });
    }

    public function down()
    {
        Schema::table('pengirimanvendor', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'setuju', 'pengiriman'])->default('menunggu');
        });
    }

    public function down()
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

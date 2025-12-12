<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('masterklasifikasi', function (Blueprint $table) {
            $table->increments('id_klasifikasi');
            $table->string('nama_klasifikasi', 100);
            $table->text('keterangan')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_klasifikasi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suratvendor', function (Blueprint $table) {
            $table->id('id_surat');
            $table->unsignedBigInteger('id_vendor');
            $table->string('nomor_surat');
            $table->string('jenis_surat');
            $table->text('deskripsi')->nullable();
            $table->string('file_surat'); // nama file yang disimpan
            $table->timestamps();

            $table->foreign('id_vendor')
                ->references('id_vendor')
                ->on('vendor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suratvendor');
    }
};

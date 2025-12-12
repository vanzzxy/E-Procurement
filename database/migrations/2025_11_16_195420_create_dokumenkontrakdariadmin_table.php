<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenkontrakdariadminTable extends Migration
{
    public function up()
    {
        Schema::create('dokumenkontrakdariadmin', function (Blueprint $table) {
            $table->id();
            $table->string('no_purchaseorder');
            $table->string('nama_perusahaan');
            $table->string('kategori_barang');
            $table->bigInteger('harga_total')->nullable();
            $table->string('jenis_surat');
            $table->text('deskripsi')->nullable();
            $table->string('dokumen'); // menyimpan nama file
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumenkontrakdariadmin');
    }
}

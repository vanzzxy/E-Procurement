<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            $table->bigInteger('harga_total')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('datakontrak', function (Blueprint $table) {
            $table->integer('harga_total')->nullable()->change();
        });
    }
};

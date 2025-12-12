<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buatkontrak', function (Blueprint $table) {
            if (! Schema::hasColumn('buatkontrak', 'harga_total')) {
                $table->bigInteger('harga_total')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buatkontrak', function (Blueprint $table) {
            //
        });
    }
};

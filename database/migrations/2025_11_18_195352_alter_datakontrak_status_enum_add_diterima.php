<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE datakontrak MODIFY status 
        ENUM('menunggu','setuju','pengiriman','selesai','diterima') 
        NOT NULL DEFAULT 'menunggu'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE datakontrak MODIFY status 
        ENUM('menunggu','setuju','pengiriman','selesai') 
        NOT NULL DEFAULT 'menunggu'");
    }
};

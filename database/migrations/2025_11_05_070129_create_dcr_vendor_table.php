<?php

// database/migrations/2025_11_05_000003_create_dcr_vendor_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dcr_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dcr_id')->constrained('dcr', 'id_dcr')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendor', 'id_vendor')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dcr_vendor');
    }
};

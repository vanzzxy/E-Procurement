<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrasiVendorKategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('registrasi_vendor_kategori')->insert([
            ['nama_kategori' => 'Tools'],
            ['nama_kategori' => 'Consumable'],
            ['nama_kategori' => 'Raw Material'],
            ['nama_kategori' => 'Material'],
        ]);
    }
}

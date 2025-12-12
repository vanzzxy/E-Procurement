<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKontrak extends Model
{
    use HasFactory;

    protected $table = 'datakontrak';

    protected $fillable = [
        'kontrak_id',
        'no_purchaseorder',
        'kategori_barang',
        'jenis_surat',
        'vendor',
        'harga_total',
        'status',
        'deskripsi',
    ];

    // Relasi ke tabel kontrak utama
    public function Kontrak()
    {
        return $this->belongsTo(BuatKontrak::class, 'kontrak_id');
    }
    
}

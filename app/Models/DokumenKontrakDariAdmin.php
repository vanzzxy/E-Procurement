<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKontrakDariAdmin extends Model
{
    use HasFactory;

    protected $table = 'dokumenkontrakdariadmin';

    protected $fillable = [
        'no_purchaseorder',
        'nama_perusahaan',
        'kategori_barang',
        'harga_total',
        'jenis_surat',
        'deskripsi',
        'dokumen',
        'deadline',
    ];

    public function datakontrak()
    {
        return $this->hasMany(DataKontrak::class, 'no_purchaseorder', 'no_purchaseorder');
    }

    public function datakontrakTerbaru()
    {
        return $this->hasOne(DataKontrak::class, 'no_purchaseorder', 'no_purchaseorder')
            ->latest('deadline');
    }
}

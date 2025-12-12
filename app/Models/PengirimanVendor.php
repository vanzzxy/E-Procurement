<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanVendor extends Model
{
    use HasFactory;

    protected $table = 'pengirimanvendor';

    protected $fillable = [
        'vendor_id',
        'kontrak_id',
        'nomor_surat_jalan',
        'no_purchaseorder',
        'no_polisi',
        'nama_sopir',
        'telepon_sopir',
        'armada',
        'file_suratjalan',
    ];

    // Relasi ke barang melalui pivot
    public function barang()
    {
        return $this->belongsToMany(
            BuatKontrakBarang::class,
            'pengirimanvendor_barang',
            'pengiriman_id',
            'buatkontrak_barang_id'
        )->withTimestamps();
    }

    public function kontrak()
    {
        return $this->belongsTo(BuatKontrak::class, 'kontrak_id', 'id');
    }

    public function datakontrak()
    {
        return $this->hasOne(DataKontrak::class, 'no_purchaseorder', 'no_purchaseorder');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuatKontrak extends Model
{
    use HasFactory;

    protected $table = 'buatkontrak';

    protected $fillable = [
        'no_purchaseorder',
        'vendor_id',
        'kategori_barang',
        'harga_total',
        'deadline',
        'is_uploaded',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function barang()
    {
        return $this->belongsToMany(MasterBarang::class, 'buatkontrak_barang', 'buatkontrak_id', 'masterbarang_id')
            ->withPivot(['jumlah', 'harga'])
            ->withTimestamps();
    }

    public function kontrak()
    {
        return $this->belongsToMany(BuatKontrak::class, 'buatkontrak_barang', 'masterbarang_id', 'buatkontrak_id')
            ->withPivot(['jumlah', 'harga'])
            ->withTimestamps();
    }

    public function datakontrak()
    {
        return $this->hasMany(DataKontrak::class, 'kontrak_id');
    }

    public function datakontrakTerbaru()
    {
        return $this->hasOne(DataKontrak::class, 'kontrak_id')
            ->latest('deadline');
    }

    public function dokumen()
    {
        return $this->belongsTo(DokumenKontrakDariAdmin::class, 'no_purchaseorder', 'no_purchaseorder');
    }
}

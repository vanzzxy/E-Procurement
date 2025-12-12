<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dcr extends Model
{
    use HasFactory;

    protected $table = 'dcr';

    protected $primaryKey = 'id_dcr';

    protected $fillable = ['kode_dcr', 'nama_dcr'];

    // Relasi many-to-many ke Vendor
    public function vendors()
    {
        return $this->belongsToMany(
            \App\Models\Vendor::class, // pastikan namespace Vendor benar
            'dcr_vendor',              // nama tabel pivot
            'dcr_id',                  // foreign key di pivot untuk Dcr
            'vendor_id'                // foreign key di pivot untuk Vendor
        );
    }
}

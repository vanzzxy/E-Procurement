<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratVendor extends Model
{
    protected $table = 'suratvendor';

    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'id_vendor',
        'id_user',
        'nomor_surat',
        'jenis_surat',
        'deskripsi',
        'file_surat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    public function suratadmin()
    {
        return $this->belongsTo(SuratAdmin::class, 'id_suratadmin', 'id_suratadmin');
    }
}

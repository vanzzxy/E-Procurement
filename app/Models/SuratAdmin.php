<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratAdmin extends Model
{
    use HasFactory;

    protected $table = 'suratadmin';

    protected $primaryKey = 'id_suratadmin';

    protected $fillable = [
        'id_vendor',
        'nama_perusahaan',
        'jenis_surat',
        'deskripsi',
        'file_surat',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    public function suratadmin()
    {
        return $this->belongsTo(SuratAdmin::class, 'id_suratadmin', 'id_suratadmin');
    }
}

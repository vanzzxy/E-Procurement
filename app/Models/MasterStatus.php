<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterStatus extends Model
{
    protected $table = 'masterstatus'; // kalau nama tabel bukan plural default

    protected $primaryKey = 'id_status'; // primary key sesungguhnya

    public $timestamps = false; // kalau tidak ada kolom created_at & updated_at

    // jika ingin mass assignable
    protected $fillable = ['id_klasifikasi', 'status', 'keterangan_status'];

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'id_klasifikasi', 'id_klasifikasi');
    }
}

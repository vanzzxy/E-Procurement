<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    protected $table = 'masterbarang';

    protected $primaryKey = 'id_masterbarang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'data_master_id',
        'spesifikasi',
        'satuan',
        'status',
    ];

    public function dataMaster()
    {
        return $this->belongsTo(DataMaster::class, 'data_master_id', 'id_master');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'masterklasifikasi_id');
    }

    public function kontrak()
    {
        return $this->belongsToMany(BuatKontrak::class, 'buatkontrak_barang', 'masterbarang_id', 'buatkontrak_id');
    }

    public function data_master()
    {
        return $this->belongsTo(DataMaster::class, 'data_master_id', 'id_master');
    }
}

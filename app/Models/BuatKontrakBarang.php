<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuatKontrakBarang extends Model
{
    protected $table = 'buatkontrak_barang'; // WAJIB, biar Laravel tidak mencari buat_kontrak_barangs

    protected $fillable = [
        'buatkontrak_id',
        'masterbarang_id',
        'jumlah',
        'harga',
    ];

    public function masterbarang()
    {
        return $this->belongsTo(MasterBarang::class, 'masterbarang_id', 'id_masterbarang');
    }

    // Relasi ke BuatKontrak
    public function buatkontrak()
    {
        return $this->belongsTo(BuatKontrak::class, 'buatkontrak_id', 'id');
    }

    public function kontrak()
    {
        return $this->belongsTo(BuatKontrak::class, 'buatkontrak_id');
    }
}

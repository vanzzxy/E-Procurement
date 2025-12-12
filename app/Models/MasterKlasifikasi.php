<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKlasifikasi extends Model
{
    protected $table = 'masterklasifikasi';
    protected $primaryKey = 'id_klasifikasi';
    public $timestamps = false;

    protected $fillable = [
        'id_klasifikasi',
        'nama_klasifikasi',
        'keterangan',
    ];

    public function statuses()
    {
        return $this->hasMany(MasterStatus::class, 'id_klasifikasi', 'id_klasifikasi');
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class MasterKlasifikasi extends Model
// {
//     protected $table = 'masterklasifikasi';
//     protected $primaryKey = 'id_klasifikasi';
//     public $timestamps = false;

//     protected $fillable = [
//         'id_klasifikasi',
//         'nama_klasifikasi',
//         'keterangan'
//     ];
// }

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMaster extends Model
{
    protected $table = 'data_master';

    protected $primaryKey = 'id_master';

    protected $fillable = ['nama_master'];

    public function masterbarang()
    {
        return $this->hasMany(Masterbarang::class, 'data_master_id', 'id_master');
    }
}

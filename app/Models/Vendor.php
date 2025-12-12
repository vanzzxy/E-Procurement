<?php

// app/Models/RegistrasiVendor.php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';

    protected $primaryKey = 'id_vendor';

    protected $fillable = [
        'asal_perusahaan',
        'npwp',
        'fax',
        'jenis_badan_usaha',
        'nama_perusahaan',
        'alamat_perusahaan',
        'email_perusahaan',
        'telepon_perusahaan',
        'kategori_perusahaan',
        'file_npwp',
        'file_iso',
        'file_siup',
        'file_skf',
        'nama_lengkap1',
        'jabatan1',
        'email1',
        'telepon1',
        'nama_lengkap2',
        'jabatan2',
        'email2',
        'telepon2',
        'id_user',
    ];

    public $timestamps = true;

    // ✨ Tambahkan ini
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Admin
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function dcr()
    {
        return $this->belongsToMany(
            Dcr::class,
            'dcr_vendor',
            'vendor_id',
            'dcr_id'
        );
    }

    public function suratvendor()
    {
        return $this->hasMany(SuratVendor::class, 'id_vendor', 'id_vendor');
    }

    public function kontrak()
    {
        return $this->hasMany(BuatKontrak::class, 'vendor_id', 'id_vendor');
    }

    // kolom dan konfigurasi lain

    public function buatkontrak()
    {
        // sesuaikan 'vendor_id' dengan nama kolom foreign key di table buatkontrak
        return $this->hasMany(BuatKontrak::class, 'vendor_id', 'id_vendor');
    }

    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'vendor') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman ini hanya untuk vendor.');
    }
}

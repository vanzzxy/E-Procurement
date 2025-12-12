<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrakBarang;
use Illuminate\Http\Request;
use App\Models\SuratAdmin;
use App\Models\PengirimanVendor;
use App\Models\DataKontrak;
use App\Models\SuratVendor;

class AdminRiwayatController extends Controller
{
    // Riwayat Masuk
    public function index(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $jenisSurat = SuratAdmin::select('jenis_surat')->distinct()->pluck('jenis_surat');

        $suratAdmin = SuratAdmin::query()
            ->when($request->jenis, fn($q) => $q->where('jenis_surat', $request->jenis))
            ->get();

        $pengiriman = PengirimanVendor::query()
            ->when($request->no_po, fn($q) => $q->where('no_purchaseorder', 'like', '%' . $request->no_po . '%'))
            ->get();

        return view('admin.riwayatadmin.riwayatmasukad', compact('jenisSurat', 'suratAdmin', 'pengiriman'));
    }

    // Riwayat Keluar
    public function keluar(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $jenisSurat = SuratVendor::select('jenis_surat')->distinct()->pluck('jenis_surat');

$datakontrak = DataKontrak::query()
    ->when($request->no_po, fn($q) => $q->where('no_purchaseorder', 'like', '%' . $request->no_po . '%'))
    ->when($request->kategori, fn($q) => $q->where('kategori_barang', $request->kategori))
    ->when($request->status, fn($q) => $q->where('status', $request->status))
    ->get();


        $suratVendor = SuratVendor::query()
            ->when($request->jenis_surat, fn($q) => $q->where('jenis_surat', $request->jenis_surat))
            ->get();

        return view('admin.riwayatadmin.riwayatkeluarad', compact('jenisSurat', 'datakontrak', 'suratVendor'));
    }

public function detail($id)
{
    // Ambil data kontrak
    $kontrak = \App\Models\DataKontrak::findOrFail($id);

    // Ambil daftar barang dari buatkontrak_barang sesuai kontrak_id
    $barang = \App\Models\BuatKontrakBarang::where('buatkontrak_id', $kontrak->kontrak_id)->get();
    return view('admin.riwayatadmin.detailkontrak', compact('kontrak', 'barang'));
}

}

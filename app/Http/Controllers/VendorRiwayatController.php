<?php

namespace App\Http\Controllers;

use App\Models\DataKontrak;
use App\Models\Suratadmin;
use App\Models\Pengirimanvendor;
use App\Models\SuratVendor;
use Illuminate\Http\Request;

class VendorRiwayatController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $jenisSurat = collect();
        $suratAdmin = collect();
        $pengiriman = collect();

        if ($vendor) {
            $vendorId = $vendor->id_vendor;

            // Ambil daftar jenis surat unik
            $jenisSurat = Suratadmin::where('id_vendor', $vendorId)
                ->select('jenis_surat')
                ->distinct()
                ->pluck('jenis_surat');

            // Ambil filter dari request
            $filterJenis = $request->jenis;
            $filterFrom  = $request->from;
            $filterTo    = $request->to;
            $filterPO    = $request->no_po;
            $filterSJ    = $request->no_surat_jalan;

            // Query Surat Admin
            $suratQuery = Suratadmin::where('id_vendor', $vendorId);
            if ($filterJenis) $suratQuery->where('jenis_surat', $filterJenis);
            if ($filterFrom)  $suratQuery->whereDate('created_at', '>=', $filterFrom);
            if ($filterTo)    $suratQuery->whereDate('created_at', '<=', $filterTo);

            $suratAdmin = $suratQuery->orderBy('created_at', 'desc')->get();

            // Query Pengiriman Vendor
            $pengirimanQuery = Pengirimanvendor::where('vendor_id', $vendorId);
            if ($filterFrom)  $pengirimanQuery->whereDate('created_at', '>=', $filterFrom);
            if ($filterTo)    $pengirimanQuery->whereDate('created_at', '<=', $filterTo);
            if ($filterPO)    $pengirimanQuery->where('no_purchaseorder', 'LIKE', "%$filterPO%");
            if ($filterSJ)    $pengirimanQuery->where('nomor_surat_jalan', 'LIKE', "%$filterSJ%");

            $pengiriman = $pengirimanQuery->orderBy('created_at', 'desc')->get();
        }

        return view('vendor.riwayatvendor.riwayatkeluar', compact(
            'jenisSurat', 'suratAdmin', 'pengiriman'
        ));
    }

        /**
     * Halaman Riwayat Surat Masuk
     */
public function riwayatMasuk(Request $request)
{
    $vendor = auth()->user()->vendor;

    $datakontrakQuery = Datakontrak::where('vendor', $vendor->nama_perusahaan);
    $suratVendorQuery = Suratvendor::where('id_vendor', $vendor->id_vendor);

    // Ambil filter dari request
    $filterPO       = $request->no_po;
    $filterKategori = $request->kategori;
    $filterStatus   = $request->status;
    $filterJenis    = $request->jenis_surat;

    // Filter datakontrak
    if ($filterPO) {
        $datakontrakQuery->where('no_purchaseorder', 'LIKE', "%$filterPO%");
    }
    if ($filterKategori) {
        $datakontrakQuery->where('kategori_barang', $filterKategori);
    }
    if ($filterStatus) {
        $datakontrakQuery->where('status', $filterStatus);
    }
    $datakontrak = $datakontrakQuery->orderBy('created_at', 'desc')->get();

    // Filter suratVendor
    if ($filterPO) {
        $suratVendorQuery->where('nomor_surat', 'LIKE', "%$filterPO%");
    }
    if ($filterJenis) {
        $suratVendorQuery->where('jenis_surat', $filterJenis);
    }
    $suratVendor = $suratVendorQuery->orderBy('created_at', 'desc')->get();

    // Ambil daftar jenis surat unik untuk dropdown
    $jenisSurat = Suratvendor::where('id_vendor', $vendor->id_vendor)
        ->select('jenis_surat')
        ->distinct()
        ->pluck('jenis_surat');

    return view('vendor.riwayatvendor.riwayatmasuk', compact('datakontrak', 'suratVendor', 'jenisSurat'));
}
public function detailDatakontrak($id)
{
    // Ambil data kontrak
    $kontrak = \App\Models\DataKontrak::findOrFail($id);

    // Ambil daftar barang dari buatkontrak_barang sesuai kontrak_id
    $barang = \App\Models\BuatKontrakBarang::where('buatkontrak_id', $kontrak->kontrak_id)->get();

    return view('vendor.riwayatvendor.detailkontrak', compact('kontrak', 'barang'));
}

}

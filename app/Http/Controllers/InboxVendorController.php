<?php

namespace App\Http\Controllers;

use App\Models\SuratAdmin;
use App\Models\SuratVendor;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InboxVendorController extends Controller
{
    public function index()
    {
        // Ambil vendor login berdasarkan id_user
        $vendor = \App\Models\Vendor::where('id_user', auth()->user()->id_user)->first();

        if (! $vendor) {
            return back()->with('error', 'Data vendor tidak ditemukan.');
        }

        // Ambil surat khusus vendor ini, kecuali SPPHB & SPH (karena itu penawaran)
        $data = \App\Models\SuratVendor::where('id_vendor', $vendor->id_vendor)
            ->whereNotIn('jenis_surat', ['SPPHB', 'SPH'])
            ->orderBy('id_surat', 'desc')
            ->get();

        return view('vendor.inboxvendor.inboxvendor', compact('data'));
    }

public function detail($id)
{
    // Ambil vendor yang login
    $vendor = Vendor::where('id_user', auth()->user()->id_user)->firstOrFail();

    // Ambil surat milik vendor ini
    $surat = SuratVendor::where('id_surat', $id)
        ->where('id_vendor', $vendor->id_vendor)
        ->firstOrFail();

    // Tentukan view berdasarkan jenis_surat
    switch (strtolower($surat->jenis_surat)) {
        case 'pengiriman':
            $view = 'vendor.inboxvendor.inboxvendordetail.inboxvendorpengiriman';
            break;

        case 'negosiasi':
            $view = 'vendor.inboxvendor.inboxvendordetail.inboxvendornegosiasi';
            break;

        case 'kontrak':
            $view = 'vendor.inboxvendor.inboxvendordetail.inboxvendorkontrak';
            break;

        case 'spb':
            $view = 'vendor.inboxvendor.inboxvendordetail.inboxvendorspb';
            break;

        default:
            // Jika jenis surat tidak dikenali, fallback ke view umum
            $view = 'vendor.inboxvendor.inboxvendordetail.inboxvendordefault';
            break;
    }

    return view($view, compact('surat'));
}


public function download($id)
{
    // Ambil vendor yang login
    $vendor = Vendor::where('id_user', auth()->user()->id_user)->firstOrFail();

    // Ambil surat vendor
    $suratVendor = SuratVendor::where('id_surat', $id)
        ->where('id_vendor', $vendor->id_vendor)
        ->firstOrFail();

    // Path file surat vendor
    $filePath = 'public/' . $suratVendor->file_surat; // kolom file_surat berisi "suratvendor/xxxx.pdf"

    if (!Storage::exists($filePath)) {
        return back()->with('error', 'File surat tidak ditemukan di server.');
    }

    return Storage::download($filePath, basename($suratVendor->file_surat));
}



    public function destroy($id, Request $request)
    {
        try {
            $surat = SuratVendor::findOrFail($id);
            $surat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen penawaran berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus dokumen: '.$e->getMessage(),
            ], 500);
        }
    }
}

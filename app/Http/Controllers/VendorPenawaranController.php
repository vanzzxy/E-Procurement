<?php

namespace App\Http\Controllers;

use App\Models\SuratVendor;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

class VendorPenawaranController extends Controller
{
    public function index()
    {
        // Ambil vendor berdasarkan user login
        $vendor = Vendor::where('id_user', auth()->user()->id_user)->first();

        if (! $vendor) {
            return back()->with('error', 'Vendor tidak ditemukan.');
        }

        // Ambil surat SPPHB & SPH milik vendor tersebut
        $data = SuratVendor::where('id_vendor', $vendor->id_vendor)
            ->whereIn('jenis_surat', ['SPPHB', 'SPH'])
            ->orderBy('id_surat', 'desc')
            ->get();

        return view('vendor.penawaran.penawaran', compact('data'));
    }

    public function download($id)
    {
        // Ambil vendor dari user login
        $vendor = Vendor::where('id_user', auth()->user()->id_user)->firstOrFail();

        // Validasi surat milik vendor ini
        $surat = SuratVendor::where('id_surat', $id)
            ->where('id_vendor', $vendor->id_vendor)
            ->firstOrFail();

        $file = 'suratvendor/'.$surat->file_surat;

        if (! Storage::disk('public')->exists($file)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($file);
    }

    public function detail($id)
    {
        // Ambil vendor berdasarkan user login
        $vendor = Vendor::where('id_user', auth()->user()->id_user)->firstOrFail();

        // Ambil surat detail milik vendor ini
        $surat = SuratVendor::where('id_surat', $id)
            ->where('id_vendor', $vendor->id_vendor)
            ->firstOrFail();

        return view('vendor.penawaran.penawarandetail', compact('surat'));
    }
}

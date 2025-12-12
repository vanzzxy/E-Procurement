<?php

namespace App\Http\Controllers;

use App\Models\DokumenKontrakDariAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKontrakDariAdminController extends Controller
{
    public function kirim(Request $request)
    {
        $request->validate([
            'no_purchaseorder' => 'required|string',
            'jenis_surat' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png', // Tambahkan jpg, jpeg, png
        ]);

        // Simpan file
        $file = $request->file('dokumen');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('dokumen-kontrak', $filename, 'public'); // storage/app/public/dokumen-kontrak

        // Simpan data ke database
        DokumenKontrakDariAdmin::create([
            'no_purchaseorder' => $request->no_purchaseorder,
            'nama_perusahaan' => $request->nama_perusahaan,
            'kategori_barang' => $request->kategori_barang,
            'harga_total' => $request->harga_total ? (int) str_replace(['Rp', '.', ','], '', $request->harga_total) : null,
            'jenis_surat' => $request->jenis_surat,
            'deskripsi' => $request->deskripsi,
            'dokumen' => $filename,
        ]);

        return response()->json(['success' => true]); // Agar AJAX bisa merespon
    }
}

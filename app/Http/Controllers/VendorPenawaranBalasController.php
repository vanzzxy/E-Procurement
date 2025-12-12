<?php

namespace App\Http\Controllers;

use App\Models\SuratAdmin;
use App\Models\SuratVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorPenawaranBalasController extends Controller
{
    public function storeAjax(Request $request)
    {
        $jenisSurat = strtoupper($request->jenis_surat); // normalize ke uppercase

        $rules = [
            'id_surat' => 'required',
            'jenis_surat' => 'required|string|max:255',
        ];

        // Hanya wajib jika bukan TIDAK SETUJU
        if ($jenisSurat !== 'TIDAK SETUJU') {
            $rules['message'] = 'required|string';
            $rules['file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        } else {
            $rules['message'] = 'nullable|string';
            $rules['file'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $request->validate($rules);

        $vendor = Auth::user()->vendor;
        if (! $vendor) {
            return response()->json(['error' => 'Vendor tidak ditemukan'], 400);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads/suratbalasan', 'public');
        }

        // Simpan data ke database
        SuratAdmin::create([
            'id_vendor' => $vendor->id_vendor,
            'nama_perusahaan' => $vendor->nama_perusahaan,
            'jenis_surat' => $jenisSurat,
            'deskripsi' => $request->message ?? '',
            'file_surat' => $filePath,
        ]);

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'jenis_surat' => $jenisSurat,
        ]);
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

    public function download($id)
    {
        $surat = SuratVendor::findOrFail($id);
        $file = 'suratvendor/'.$surat->file_surat;

        if (! Storage::disk('public')->exists($file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($file);
    }
}

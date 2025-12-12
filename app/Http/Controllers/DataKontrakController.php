<?php

namespace App\Http\Controllers;

use App\Models\DataKontrak;
use App\Models\DokumenKontrakDariAdmin;
use Illuminate\Http\Request;
use Storage;

class DataKontrakController extends Controller
{
    public function index()
    {
        $kontraks = Datakontrak::orderBy('created_at', 'desc')->get();

        return view('admin.kontrakadmin.datakontrak', compact('kontraks'));
    }

    public function deleteUpload($id)
    {
        $kontrak = Datakontrak::findOrFail($id);

        // Hapus semua dokumen terkait kontrak ini
        $docs = DokumenKontrakDariAdmin::where('no_purchaseorder', $kontrak->no_purchaseorder)->get();

        foreach ($docs as $doc) {

            // Hapus file dokumen fisik
            if ($doc->dokumen && Storage::disk('public')->exists($doc->dokumen)) {
                Storage::disk('public')->delete($doc->dokumen);
            }

            // Hapus row dari tabel
            $doc->delete();
        }

        // Hapus file path_file jika ada
        if ($kontrak->path_file && Storage::exists($kontrak->path_file)) {
            Storage::delete($kontrak->path_file);
        }

        // Hapus kontrak
        $kontrak->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kontrak dan dokumen terkait berhasil dihapus.',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $kontrak = Datakontrak::findOrFail($id);
        $kontrak->status = $request->status;
        $kontrak->save();

        return response()->json([
            'success' => true,
            'status' => $kontrak->status,
        ]);
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'kontrak_id' => 'required|exists:datakontrak,id',
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
            'jenis_surat' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Ambil data kontrak
        $kontrak = Datakontrak::findOrFail($request->kontrak_id);

        // Upload file ke storage/public/dokumen_kontrak
        $path = $request->file('dokumen')->store('dokumen_kontrak', 'public');

        // Simpan ke tabel dokumenkontrakdariadmin
        DokumenKontrakDariAdmin::create([
            'no_purchaseorder' => $kontrak->no_purchaseorder,
            'nama_perusahaan' => $kontrak->vendor, // atau $kontrak->vendor->nama jika relasi
            'kategori_barang' => $kontrak->kategori_barang,
            'harga_total' => $kontrak->harga_total,
            'jenis_surat' => $request->jenis_surat,
            'deskripsi' => $request->deskripsi,
            'dokumen' => $path,
        ]);

        // Update status kontrak (enum: menunggu / setuju / pengiriman)
        $kontrak->update([
            'status' => 'menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dikirim dan status diperbarui.',
        ]);
    }
}

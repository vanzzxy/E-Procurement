<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrak;
use App\Models\BuatKontrakBarang;
use App\Models\DataKontrak;
use App\Models\DokumenKontrakDariAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorKontrakController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor->nama_perusahaan;

        $kontrak = DokumenKontrakDariAdmin::with(['datakontrakTerbaru'])
            ->where('nama_perusahaan', $vendor)
            ->orderBy('id', 'desc') // Ambil dokumen admin terbaru dulu
            ->get()
            ->unique('no_purchaseorder') // Saring hanya 1 PO saja
            ->values();

        return view('vendor.kontrakvendor.kontrakvendor', compact('kontrak'));
    }

    public function download($id)
    {
        $dokumen = DokumenKontrakDariAdmin::findOrFail($id);

        // kolom dokumen diasumsikan berisi path seperti 'dokumen_kontrak/filename.pdf'
        $path = $dokumen->dokumen;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        // optional: beri nama file saat di-download berdasarkan PO atau nama file asli
        $downloadName = $dokumen->no_purchaseorder.'_'.basename($path);

        return Storage::disk('public')->download($path, $downloadName);
    }

    public function detail($id)
    {
        $kontrak = DokumenKontrakDariAdmin::findOrFail($id);

        // Ambil kontrak asli berdasarkan no_purchaseorder
        $buatKontrak = BuatKontrak::where('no_purchaseorder', $kontrak->no_purchaseorder)->first();

        if (! $buatKontrak) {
            return redirect()->back()->with('error', 'Detail kontrak tidak ditemukan.');
        }

        // Ambil item barang
        $items = BuatKontrakBarang::where('buatkontrak_id', $buatKontrak->id)
            ->join('masterbarang', 'masterbarang.id_masterbarang', '=', 'buatkontrak_barang.masterbarang_id')
            ->select(
                'buatkontrak_barang.*',
                'masterbarang.kode_barang',
                'masterbarang.nama_barang',
                'masterbarang.spesifikasi',
                'masterbarang.satuan'
            )
            ->get();

        return view('vendor.kontrakvendor.detailkontrakvendor', compact('kontrak', 'buatKontrak', 'items'));
    }

    public function getLatestPO()
    {
        // Ambil 1 purchase order terbaru berdasarkan created_at
        $poTerbaru = BuatKontrak::with(['datakontrakTerbaru'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $poTerbaru) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data purchase order.',
            ]);
        }

        // Ambil dokumen admin berdasarkan no_purchaseorder
        $dokAdmin = DokumenKontrakDariAdmin::with('datakontrakTerbaru')
            ->where('no_purchaseorder', $poTerbaru->no_purchaseorder)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'po_id' => $poTerbaru->id,
                'no_purchaseorder' => $poTerbaru->no_purchaseorder,
                'deadline_kontrak' => $poTerbaru->deadline,
                'datakontrak_terbaru' => $poTerbaru->datakontrakTerbaru,
                'dok_admin' => $dokAdmin,
            ],
        ]);
    }

    public function edit($id)
    {
        $data = DataKontrak::findOrFail($id);

        return view('vendor.kontrakvendor.editstatus', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Baca JSON dari fetch PUT
        $requestData = json_decode($request->getContent(), true);
        if ($requestData) {
            $request->merge($requestData);
        }

        $data = DataKontrak::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!',
        ]);
    }
}

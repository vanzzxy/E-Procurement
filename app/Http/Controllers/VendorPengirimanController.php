<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrak;
use App\Models\BuatKontrakBarang;
use App\Models\Datakontrak;
use App\Models\PengirimanVendor;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorPengirimanController extends Controller
{
    // ============================
    // HALAMAN INDEX
    // ============================
    public function index()
    {
        $vendorID = Auth::user()->vendor->id_vendor;

        $pengiriman = PengirimanVendor::where('vendor_id', $vendorID)
            ->with(['barang.masterbarang', 'kontrak', 'datakontrak'])
            ->get();

        return view('vendor.pengiriman.pengiriman', compact('pengiriman'));
    }

    // ============================
    // HALAMAN FORM TAMBAH PENGIRIMAN
    // ============================
    public function create()
    {
        // Ambil No PO dari datakontrak yang statusnya SETUJU
        $purchaseOrders = Datakontrak::where('status', 'setuju')
            ->select('no_purchaseorder', 'kontrak_id')
            ->get();

        return view('vendor.pengiriman.pengirimantambah', compact('purchaseOrders'));
    }

    // ============================
    // AJAX Ambil Barang Per PO
    // ============================
    public function getBarang($po)
    {
        $kontrak = BuatKontrak::where('no_purchaseorder', $po)->first();

        if (! $kontrak) {
            return response()->json([]);
        }

        $barang = BuatKontrakBarang::where('buatkontrak_id', $kontrak->id)
            ->with('masterbarang')
            ->get();

        $data = $barang->map(function ($item) use ($po) {
            return [
                'no_purchaseorder' => $po,
                'item_id' => $item->id,
                'kode_barang' => $item->masterbarang->kode_barang ?? '-',
                'spesifikasi' => $item->masterbarang->spesifikasi ?? '-',
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'satuan' => $item->masterbarang->satuan ?? '-',
            ];
        });

        return response()->json($data);
    }

    // ============================
    // SIMPAN PENGIRIMAN
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'no_surat_jalan' => 'required|string',
            'no_purchaseorder' => 'required|string',
            'no_polisi' => 'required|string',
            'nama_sopir' => 'required|string',
            'telp_sopir' => 'required|string',
            'armada' => 'required|string',
            'dokumen_surat_jalan' => 'nullable|file|mimes:pdf,jpg,png',
            'kirim' => 'required|array',
        ]);

        $vendor = Vendor::where('id_user', Auth::id())->firstOrFail();

        // AMBIL KONTRAK DARI NO PO
        $kontrak = BuatKontrak::where('no_purchaseorder', $request->no_purchaseorder)->first();

        if (! $kontrak) {
            return back()->with('error', 'Kontrak untuk PO ini tidak ditemukan.');
        }

        // SIMPAN FILE
        $filePath = $request->hasFile('dokumen_surat_jalan')
            ? $request->file('dokumen_surat_jalan')->store('suratjalan', 'public')
            : null;

        // SIMPAN DATA PENGIRIMAN
        $pengiriman = PengirimanVendor::create([
            'vendor_id' => $vendor->id_vendor,
            'kontrak_id' => $kontrak->id,
            'nomor_surat_jalan' => $request->no_surat_jalan,
            'no_purchaseorder' => $request->no_purchaseorder,
            'no_polisi' => $request->no_polisi,
            'nama_sopir' => $request->nama_sopir,
            'telepon_sopir' => $request->telp_sopir,
            'armada' => $request->armada,
            'file_suratjalan' => $filePath,
        ]);

        // RELASI BARANG
        if ($request->has('kirim')) {
            foreach ($request->kirim as $item_id) {
                $pengiriman->barang()->attach($item_id);
            }
        }

        // UPDATE STATUS KONTRAK BERDASARKAN PO
        Datakontrak::where('kontrak_id', $kontrak->id)
            ->update(['status' => 'pengiriman']);

        return redirect()->route('vendor.pengiriman')
            ->with('success', 'Data pengiriman berhasil disimpan dan status kontrak diperbarui.');
    }

    // ============================
    // DETAIL MODAL
    // ============================
    public function detailModal($id)
    {
        $pengiriman = PengirimanVendor::with([
            'barang.masterbarang',
            'kontrak',
        ])->findOrFail($id);

        $barangList = $pengiriman->barang;

        return view('vendor.pengiriman.pengirimandetail', compact('pengiriman', 'barangList'));
    }

    // ============================
    // UPDATE STATUS DITERIMA (AJAX)
    // ============================
    // Update status selesai
    public function selesai($id)
    {
        $pengiriman = PengirimanVendor::findOrFail($id);

        DataKontrak::where('no_purchaseorder', $pengiriman->no_purchaseorder)
            ->update(['status' => 'selesai']);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $pengiriman = PengirimanVendor::findOrFail($id);

        // Hapus pivot relasi barang
        if ($pengiriman->barang()) {
            $pengiriman->barang()->detach();
        }

        // Hapus file jika ada
        if ($pengiriman->file_suratjalan && file_exists(storage_path('app/public/'.$pengiriman->file_suratjalan))) {
            unlink(storage_path('app/public/'.$pengiriman->file_suratjalan));
        }

        // Hapus data utama
        $pengiriman->delete();

        return redirect()->back()->with('success', 'Data pengiriman berhasil dihapus.');
    }

    public function detail($id)
    {
        $pengiriman = PengirimanVendor::findOrFail($id);

        // Ambil purchase order
        $po = $pengiriman->no_purchaseorder;

        // Ambil data kontrak berdasarkan PO
        $kontrak = BuatKontrak::where('no_purchaseorder', $po)->first();

        // Ambil detail barang dari buatkontrak_barang
        $barangList = BuatKontrakBarang::with('masterbarang')
            ->where('buatkontrak_id', $kontrak->id)
            ->get();

        return view('vendor.pengiriman.detail', compact(
            'pengiriman',
            'kontrak',
            'barangList'
        ));
    }
}

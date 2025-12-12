<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrak;
use App\Models\BuatKontrakBarang;
use App\Models\Datakontrak;
use App\Models\PengirimanVendor;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPengirimanController extends Controller
{
    // ============================
    // HALAMAN INDEX
    // ============================
    public function index()
    {
        $pengiriman = PengirimanVendor::with(['barang.masterbarang', 'kontrak', 'datakontrak'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengirimanadmin.pengirimanadmin', compact('pengiriman'));
    }

    // ============================
    // HALAMAN FORM TAMBAH PENGIRIMAN
    // ============================
    public function create()
    {
        $vendorId = auth()->user()->vendor->id_vendor;

        $purchaseOrders = BuatKontrak::where('vendor_id', $vendorId)
            ->with('barang')
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
        $kontrakID = $vendor->buatkontrak()->first()->id ?? null;

        if (! $kontrakID) {
            return back()->with('error', 'Vendor belum memiliki kontrak aktif.');
        }

        $filePath = $request->hasFile('dokumen_surat_jalan')
            ? $request->file('dokumen_surat_jalan')->store('suratjalan', 'public')
            : null;

        $pengiriman = PengirimanVendor::create([
            'vendor_id' => $vendor->id_vendor,
            'kontrak_id' => $kontrakID,
            'nomor_surat_jalan' => $request->no_surat_jalan,
            'no_purchaseorder' => $request->no_purchaseorder,
            'no_polisi' => $request->no_polisi,
            'nama_sopir' => $request->nama_sopir,
            'telepon_sopir' => $request->telp_sopir,
            'armada' => $request->armada,
            'file_suratjalan' => $filePath,
        ]);

        if ($request->has('kirim')) {
            foreach ($request->kirim as $item_id) {
                $pengiriman->barang()->attach($item_id);
            }
        }

        Datakontrak::where('kontrak_id', $kontrakID)
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

        return view('admin.pengirimanadmin.pengirimanadmindetail', compact('pengiriman', 'barangList'));
    }

    // ============================
    // UPDATE STATUS DITERIMA (AJAX)
    // ============================
    // Update status selesai
    public function diterima($id)
    {
        $pengiriman = PengirimanVendor::findOrFail($id);

        // update status kontrak menjadi diterima
        Datakontrak::where('kontrak_id', $pengiriman->kontrak_id)
            ->update(['status' => 'diterima']);

        // cek apakah masih ada pengiriman lain pada kontrak ini
        $totalPengiriman = PengirimanVendor::where('kontrak_id', $pengiriman->kontrak_id)->count();

        // // jika hanya ada SATU pengiriman, otomatis selesai
        // if ($totalPengiriman <= 1) {
        //     Datakontrak::where('kontrak_id', $pengiriman->kontrak_id)
        //         ->update(['status' => 'selesai']);
        // }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $pengiriman = PengirimanVendor::with(['barang.masterbarang', 'kontrak', 'vendor'])
            ->findOrFail($id);

        return view('admin.pengiriman.detail', compact('pengiriman'));
    }
}

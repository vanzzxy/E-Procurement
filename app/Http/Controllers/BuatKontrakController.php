<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrak;
use App\Models\DataKontrak;
use App\Models\MasterBarang;
use App\Models\Vendor;
use Illuminate\Http\Request;

class BuatKontrakController extends Controller
{
    // Halaman daftar kontrak
    public function index()
    {
        $kontraks = BuatKontrak::with('vendor')->get();

        return view('admin.kontrakadmin.klasifikasikontrak.klasifikasikontrak', compact('kontraks'));
    }

    // Form tambah kontrak
    public function create()
    {
        $vendors = Vendor::all();
        $kategoris = ['Tools', 'Consumable', 'Material', 'Raw Material'];

        return view('admin.kontrakadmin.buatkontrak', compact('vendors', 'kategoris'));
    }

    // Simpan kontrak (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'no_purchaseorder' => 'required',
            'vendor_id' => 'required',
            'kategori_barang' => 'required',
            'deadline' => 'nullable|date',
            'barang_ids' => 'required|array',
        ]);

        $kontrak = BuatKontrak::create([
            'no_purchaseorder' => $request->no_purchaseorder,
            'vendor_id' => $request->vendor_id,
            'kategori_barang' => $request->kategori_barang,
            'deadline' => $request->deadline,
            'harga_total' => 0, // harga diset otomatis nanti
        ]);

        foreach ($request->barang_ids as $barangId) {
            $kontrak->barang()->attach($barangId, [
                'jumlah' => 1,
                'harga' => 0,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Kontrak berhasil dibuat! Silakan isi harga dan jumlah di halaman detail.',
        ]);
    }

    // Ajax get barang
    public function getBarangByKategori($kategori)
    {
        $barangs = MasterBarang::where('status', 'Aktif')
            ->where('data_master_id', function ($q) use ($kategori) {
                $q->select('id_master')->from('data_master')
                    ->where('nama_master', $kategori);
            })
            ->get();

        return response()->json($barangs);
    }

    public function detail($id)
    {
        $kontrak = BuatKontrak::with('barang')->findOrFail($id);
        $semuaBarang = MasterBarang::all();

        return view('admin.kontrakadmin.klasifikasikontrak.detailklasifikasikontrak', compact('kontrak', 'semuaBarang'));
    }

    public function addBarang(Request $request, $id)
    {
        $request->validate([
            'masterbarang_id' => 'required',
            'jumlah' => 'required|min:1|integer',
            'harga' => 'required|min:1|integer',
        ]);

        $kontrak = BuatKontrak::findOrFail($id);

        $kontrak->barang()->attach($request->masterbarang_id, [
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);

        $this->updateTotal($kontrak);

        return back()->with('success', 'Barang berhasil ditambahkan!');

    }

    public function updateBarang(Request $request, $id, $barangId)
    {
        $jumlah = (int) preg_replace('/[^0-9]/', '', $request->jumlah);
        $harga = (int) preg_replace('/[^0-9]/', '', $request->harga);

        $subtotal = $jumlah * $harga;

        $kontrak = BuatKontrak::findOrFail($id);

        // Update pivot
        $kontrak->barang()->updateExistingPivot($barangId, [
            'jumlah' => $jumlah,
            'harga' => $harga,
            'subtotal' => $subtotal,
        ]);

        // Wajib update total harga
        $this->updateTotal($kontrak);

        return back()->with('success', 'Barang berhasil diperbarui');
    }

    private function updateTotal($kontrak)
    {
        $total = $kontrak->barang->sum(
            fn ($b) => $b->pivot->jumlah * $b->pivot->harga
        );

        $kontrak->update(['harga_total' => $total]);
    }

    /**
     * Hapus klasifikasi kontrak beserta relasi pivot
     */
    public function destroy($id)
    {
        $kontrak = BuatKontrak::with('barang')->find($id);

        if (! $kontrak) {
            return redirect()->route('buatkontrak.index')->with('error', 'Kontrak tidak ditemukan.');
        }

        try {
            // Lepas relasi pivot barang
            $kontrak->barang()->detach();

            // Hapus kontrak dari tabel buat_kontrak
            $kontrak->delete();

            // Jangan hapus DataKontrak
            // DataKontrak tetap ada

            return redirect()->route('buatkontrak.index')->with('success', 'Kontrak berhasil dihapus, data upload tetap tersimpan.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus kontrak: '.$e->getMessage());

            return redirect()->route('buatkontrak.index')->with('error', 'Gagal menghapus kontrak. Periksa log.');
        }
    }

    public function destroyBarang($id, $barangId)
    {
        $kontrak = BuatKontrak::findOrFail($id);

        // Hapus barang dari pivot
        $kontrak->barang()->detach($barangId);

        // Update total harga
        $this->updateTotal($kontrak);

        return back()->with('success', 'Barang berhasil dihapus dari kontrak.');
    }

    public function upload($id)
    {
        $kontrak = BuatKontrak::with('vendor')->findOrFail($id);

        DataKontrak::create([
            'kontrak_id' => $kontrak->id,
            'no_purchaseorder' => $kontrak->no_purchaseorder,
            'kategori_barang' => $kontrak->kategori_barang,
            'vendor' => $kontrak->vendor->nama_perusahaan ?? '-',
            'harga_total' => $kontrak->harga_total,
            'deadline' => $kontrak->deadline,
        ]);

        return redirect()->route('datakontrak.index')
            ->with('success', 'Kontrak berhasil di-upload!');
    }

    public function getKategoriVendor($id)
    {
        $vendor = Vendor::find($id);

        if (! $vendor) {
            return response()->json([]);
        }

        // Jika kategori_perusahaan = "Tools, Consumable"
        $kategori = array_map('trim', explode(',', $vendor->kategori_perusahaan));

        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'no_purchaseorder' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        // Ambil kontrak
        $kontrak = BuatKontrak::findOrFail($id);

        // Update data
        $kontrak->no_purchaseorder = $request->no_purchaseorder;
        $kontrak->deadline = $request->deadline;
        $kontrak->save();

        return redirect()->back()->with('success', 'Informasi kontrak berhasil diperbarui.');
    }
}

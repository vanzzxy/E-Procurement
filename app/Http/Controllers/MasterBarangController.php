<?php

namespace App\Http\Controllers;

use App\Models\DataMaster;
use App\Models\MasterBarang;
use Illuminate\Http\Request;

class MasterBarangController extends Controller
{
    public function index()
    {
        $barang = MasterBarang::with('dataMaster')->get();
        $dataMaster = DataMaster::all();

        return view('admin.datamaster.masterbarang.masterbarang', compact('barang', 'dataMaster'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:masterbarang',
            'nama_barang' => 'required',
            'data_master_id' => 'required',
        ]);

        MasterBarang::create($request->all());

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $barang = MasterBarang::findOrFail($id);

        $barang->update($request->all());

        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        MasterBarang::destroy($id);

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}

// namespace App\Http\Controllers;

// use App\Models\DataMaster;
// use App\Models\MasterBarang;
// use Illuminate\Http\Request;

// class MasterBarangController extends Controller
// {
//     // === TAMPILKAN SEMUA BARANG ===
//     public function index()
//     {
//         $barang = MasterBarang::with('dataMaster')->get();
//         $dataMaster = DataMaster::all(); // ← Tambahkan ini
//         return view('admin.datamaster.masterbarang.masterbarang', compact('barang', 'dataMaster'));

//     }

//     // === FORM TAMBAH BARANG ===
//     public function create()
//     {
//         $dataMaster = DataMaster::all();
//         return view('admin.datamaster.masterbarang.create', compact('dataMaster'));
//     }

//     // === SIMPAN BARANG BARU ===
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'kode_barang' => 'required|unique:master_barang,kode_barang',
//             'nama_barang' => 'required',
//             'data_master_id' => 'nullable|exists:data_master,id_master',
//             'spesifikasi' => 'nullable',
//             'satuan' => 'nullable',
//             'status' => 'required|in:Aktif,Nonaktif',
//         ]);

//         MasterBarang::create($validated);

//         return redirect()->route('masterbarang.index')->with('success', 'Barang berhasil ditambahkan!');
//     }
//     // public function store(Request $request)
//     // {
//     //     $validated = $request->validate([
//     //         'kode_barang' => 'required|unique:master_barang,kode_barang',
//     //         'nama_barang' => 'required|string|max:100',
//     //         'data_master_id_master' => 'nullable|exists:data_master,id_master',
//     //         'spesifikasi' => 'nullable|string',
//     //         'satuan' => 'nullable|string|max:20',
//     //         'status' => 'required|in:Aktif,Nonaktif',
//     //     ]);

//     //     MasterBarang::create($validated);

//     //     return redirect()->route('masterbarang.index')->with('success', 'Barang berhasil ditambahkan!');
//     // }

//     // === FORM EDIT BARANG ===
//     public function edit($id)
//     {
//         $barang = MasterBarang::findOrFail($id);
//         $dataMaster = DataMaster::all();
//         return view('admin.datamaster.masterbarang.edit', compact('barang', 'dataMaster'));
//     }

//     // === UPDATE DATA BARANG ===
//     public function update(Request $request, $id)
//     {
//         $barang = MasterBarang::findOrFail($id);

//         $validated = $request->validate([
//             'kode_barang' => 'required|unique:master_barang,kode_barang,' . $id . ',id_masterbarang',
//             'nama_barang' => 'required|string|max:100',
//             'data_master_id_master' => 'nullable|exists:data_master,id_master',
//             'spesifikasi' => 'nullable|string',
//             'satuan' => 'nullable|string|max:20',
//             'status' => 'required|in:Aktif,Nonaktif',
//         ]);

//         $barang->update($validated);

//         return redirect()->route('masterbarang.index')->with('success', 'Barang berhasil diperbarui!');
//     }

//     // === HAPUS DATA BARANG ===
//     public function destroy($id)
//     {
//         $barang = MasterBarang::findOrFail($id);
//         $barang->delete();

//         return redirect()->route('masterbarang.index')->with('success', 'Barang berhasil dihapus!');
//     }
// }

<?php

namespace App\Http\Controllers;

use App\Models\MasterKlasifikasi;
use Illuminate\Http\Request;

class MasterKlasifikasiController extends Controller
{
    public function index()
    {
        $data = MasterKlasifikasi::all();

        return view('admin.datamaster.masterklasifikasi.masterklasifikasi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_klasifikasi' => ['required', 'regex:/^\d+$/', 'unique:masterklasifikasi,id_klasifikasi'],
            'nama_klasifikasi' => 'required',
        ], [
            'id_klasifikasi.required' => 'ID Klasifikasi tidak boleh kosong!',
            'id_klasifikasi.regex' => 'ID Klasifikasi harus berupa angka!',
            'id_klasifikasi.unique' => 'ID Klasifikasi sudah ada!',
            'nama_klasifikasi.required' => 'Nama Klasifikasi tidak boleh kosong!',
        ]);


        MasterKlasifikasi::create([
            'id_klasifikasi' => $request->id_klasifikasi,
            'nama_klasifikasi' => $request->nama_klasifikasi,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_klasifikasi' => 'required|numeric',
            'nama_klasifikasi' => 'required',
        ]);

        // cari berdasarkan ID lama
        $klasifikasi = MasterKlasifikasi::where('id_klasifikasi', $request->old_id)->first();

        if (!$klasifikasi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        $klasifikasi->id_klasifikasi = $request->id_klasifikasi;
        $klasifikasi->nama_klasifikasi = $request->nama_klasifikasi;
        $klasifikasi->keterangan = $request->keterangan;
        $klasifikasi->save();

        return redirect()->back()->with('success', 'Berhasil update!');
    }

    public function destroy($id)
    {
        $data = MasterKlasifikasi::findOrFail($id);
        $data->delete();

        return redirect('/masterklasifikasi')->with('success', 'Data berhasil dihapus');
    }
}

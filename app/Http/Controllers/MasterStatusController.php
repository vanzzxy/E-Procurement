<?php

namespace App\Http\Controllers;

use App\Models\MasterStatus;
use Illuminate\Http\Request;

class MasterStatusController extends Controller
{
    public function index()
    {
        // Ambil semua masterstatus beserta relasi klasifikasi
        $data = \App\Models\MasterStatus::with('klasifikasi')->get();

        // Ambil semua klasifikasi untuk dropdown
        $klasifikasi = \App\Models\MasterKlasifikasi::all();

        // Kirim ke view
        return view('admin.datamaster.masterstatus.masterstatus', compact('data', 'klasifikasi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_klasifikasi' => 'required|exists:masterklasifikasi,id_klasifikasi',
            'status' => 'required|string|max:50',
            'keterangan_status' => 'nullable|string',
        ]);

        // Simpan data ke tabel masterstatus
        MasterStatus::create([
            'id_klasifikasi' => $request->id_klasifikasi,
            'status' => $request->status,
            'keterangan_status' => $request->keterangan_status,
        ]);

        // Redirect atau response
        return redirect()->route('masterstatus.index')
            ->with('success', 'Data Master Status berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_status' => 'required',
            'status' => 'required',
            'keterangan_status' => 'required',
        ]);

        $status = MasterStatus::find($request->id_status);
        if (! $status) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $status->status = $request->status;
        $status->keterangan_status = $request->keterangan_status;
        $status->save();

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function delete($id)
    {
        MasterStatus::where('id_status', $id)->delete();

        return back()->with('success', 'Status berhasil dihapus');
    }
}

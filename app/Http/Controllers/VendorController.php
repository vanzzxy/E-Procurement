<?php

namespace App\Http\Controllers;

use App\Models\DataMaster;
use App\Models\SuratVendor;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function detail($id)
    {
        $vendor = Vendor::where('id_vendor', $id)->first();

        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor tidak ditemukan!');
        }

        return view('admin.daftarvendor.detaildatavendor', compact('vendor'));
    }



    public function index()
    {
        // Ambil semua vendor dengan pagination (misal 10 per halaman)
        $vendors = Vendor::get();

        // Kirim ke view
        return view('admin/daftarvendor/daftarvendor', compact('vendors'));
    }



    public function registrasi()
    {
        return view('webutama.registrasi'); // halaman yang dituju
    }



    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:user,username',
            'password' => 'required|min:6',
            'email_perusahaan' => 'required|email|unique:vendor,email_perusahaan',
            'asal_perusahaan' => 'required',
            'npwp' => 'required|unique:vendor,npwp',
            'nama_perusahaan' => 'required',
            'alamat_perusahaan' => 'required',
            'telepon_perusahaan' => 'required',
            'kategori_perusahaan' => 'required|array',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,png',
            'file_iso' => 'nullable|file|mimes:pdf,jpg,png',
            'file_siup' => 'nullable|file|mimes:pdf,jpg,png',
            'file_skf' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        DB::beginTransaction();
        try {
            // Simpan user (akun perusahaan)
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email_perusahaan, // email utama dari perusahaan
                'role' => 'vendor',
            ]);

            // Handle upload file
            $fileNpwp = $request->file('file_npwp') ? $request->file('file_npwp')->store('uploads/vendor/npwp', 'public') : null;
            $fileIso = $request->file('file_iso') ? $request->file('file_iso')->store('uploads/vendor/iso', 'public') : null;
            $fileSiup = $request->file('file_siup') ? $request->file('file_siup')->store('uploads/vendor/siup', 'public') : null;
            $fileSkf = $request->file('file_skf') ? $request->file('file_skf')->store('uploads/vendor/skf', 'public') : null;

            // Simpan vendor
            Vendor::create([
                'asal_perusahaan' => $request->asal_perusahaan,
                'npwp' => $request->npwp,
                'fax' => $request->fax,
                'jenis_badan_usaha' => $request->jenis_badan_usaha,
                'nama_perusahaan' => $request->nama_perusahaan,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'email_perusahaan' => $request->email_perusahaan,
                'telepon_perusahaan' => $request->telepon_perusahaan,
                'kategori_perusahaan' => json_encode($request->kategori_perusahaan),

                'file_npwp' => $fileNpwp,
                'file_iso' => $fileIso,
                'file_siup' => $fileSiup,
                'file_skf' => $fileSkf,

                'nama_lengkap1' => $request->namaLengkap1,
                'jabatan1' => $request->jabatan1,
                'email1' => $request->email1,
                'telepon1' => $request->telepon1,

                'nama_lengkap2' => $request->namaLengkap2,
                'jabatan2' => $request->jabatan2,
                'email2' => $request->email2,
                'telepon2' => $request->telepon2,

                'id_user' => $user->id_user,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Registrasi vendor berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // Menampilkan detail vendor
    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('admin.daftarvendor.detaildatavendor', compact('vendor'));
    }



    // Upload surat vendor
    public function uploadSurat(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendor,id_vendor',
            'nomor_surat' => 'required',
            'jenis_surat' => 'required',
            'deskripsi' => 'required',
            'file_surat' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('file_surat');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/suratvendor', $filename);

        // ✅ simpan DB
        SuratVendor::create([
            'id_vendor' => $request->vendor_id,
            'id_user' => auth()->id(),   // ✅ SIMPAN USER PENGIRIM DI DATABASE
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'deskripsi' => $request->deskripsi,
            'file_surat' => $filename,
        ]);

        return response()->json(['success' => true]);
    }



    public function detailVendor($id)
    {
        $vendor = Vendor::with('suratvendor')->where('id_vendor', $id)->first();

        return view('admin.vendor.detail', compact('vendor'));
    }



    public function getKategori($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([]);
        }

        // Jika kategori_perusahaan disimpan sebagai JSON
        $kategori = json_decode($vendor->kategori_perusahaan, true);

        return response()->json($kategori ?? []);
    }


}

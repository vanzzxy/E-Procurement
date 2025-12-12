<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\DataMaster;
use Illuminate\Support\Facades\Validator;

class VendorProfileController extends Controller
{
    public function index($id)
    {
        $vendor = Vendor::findOrFail($id);
        $masterCategories = DataMaster::all();

        return view('vendor.profilvendor.profilvendor', compact('vendor', 'masterCategories'));
    }

    public function updateProfile(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $kategori = json_decode($request->kategori_hidden, true);

        $vendor->update([
            'jenis_badan_usaha' => $request->jenis_badan_usaha,
            'nama_perusahaan'   => $request->nama_perusahaan,
            'asal_perusahaan'   => $request->asal_perusahaan,
            'npwp'              => $request->npwp,
            'fax'               => $request->fax,
            'telepon_perusahaan'=> $request->telepon_perusahaan,
            'email_perusahaan'  => $request->email_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'kategori_perusahaan' => json_encode($kategori),

            'nama_lengkap1' => $request->nama_lengkap1,
            'jabatan1'      => $request->jabatan1,
            'email1'        => $request->email1,
            'telepon1'      => $request->telepon1,

            'nama_lengkap2' => $request->nama_lengkap2,
            'jabatan2'      => $request->jabatan2,
            'email2'        => $request->email2,
            'telepon2'      => $request->telepon2,
        ]);

        return response()->json(['success' => true]);
    }

    public function updatePhoto(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'vendor_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/vendor'), $filename);

            $photoPath = 'img/vendor/' . $filename;

            if ($vendor->user) {
                $vendor->user->photo = $photoPath;
                $vendor->user->save();
            }

            return response()->json(['url' => asset($photoPath)]);
        }

        return response()->json(['error' => true], 400);
    }

    // ===================== UPLOAD DOKUMEN =====================
public function uploadDokumen(Request $request)
{
    $request->validate([
        'document' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        'field'    => 'required|string'
    ]);

    $vendor = Auth::user()->vendor;

    $allowedFields = [
        'file_npwp' => 'npwp',
        'file_iso'  => 'iso',
        'file_siup' => 'siup',
        'file_skf'  => 'skf'
    ];

    if (!isset($allowedFields[$request->field])) {
        return response()->json(['message' => 'Field tidak valid'], 400);
    }

    // Upload
    $file = $request->file('document');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('dokumen_vendor'), $filename);

    // Simpan DB
    $vendor->{$request->field} = $filename;
    $vendor->save();

    $jenis = $allowedFields[$request->field];

    return response()->json([
        'download_url' => route('vendor.downloadDokumen', $jenis),
        'delete_url'   => route('vendor.deleteDokumen', $jenis)
    ]);
}


    // ===================== DOWNLOAD =====================
    public function downloadDokumen($field)
    {
        $vendor = Auth::user()->vendor;
        if (!$vendor) return back()->with('error', 'Vendor tidak ditemukan');

        $allowedFields = ['npwp' => 'file_npwp', 'iso' => 'file_iso', 'siup' => 'file_siup', 'skf' => 'file_skf'];

        if (!isset($allowedFields[$field])) 
            return back()->with('error', 'Jenis dokumen tidak valid');

        $dbField = $allowedFields[$field];
        $filename = $vendor->$dbField;

        if (!$filename) return back()->with('error', 'Dokumen tidak ditemukan');

        $path = public_path("dokumen_vendor/$filename");
        if (!file_exists($path)) return back()->with('error', 'File fisik tidak ada');

        return response()->download($path);
    }

    // ===================== DELETE =====================
public function deleteDokumen($field)
{
    $vendor = Auth::user()->vendor;

    $allowed = [
        'npwp' => 'file_npwp',
        'iso'  => 'file_iso',
        'siup' => 'file_siup',
        'skf'  => 'file_skf'
    ];

    if (!isset($allowed[$field])) {
        return response()->json(['message' => 'Field tidak valid'], 400);
    }

    $dbField = $allowed[$field];

    if ($vendor->$dbField) {
        $filepath = public_path('dokumen_vendor/' . $vendor->$dbField);
        if (file_exists($filepath)) unlink($filepath);
    }

    $vendor->$dbField = null;
    $vendor->save();

    return response()->json([
        'upload_url' => route('vendor.uploadDokumen'),
        'field'      => $dbField,
        'label'      => strtoupper($field)
    ]);
}

}

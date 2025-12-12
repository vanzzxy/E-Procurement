<?php

namespace App\Http\Controllers;

use App\Models\Dcr;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DcrController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian
        $query = Dcr::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('kode_dcr', 'like', "%{$request->search}%")
                ->orWhere('nama_dcr', 'like', "%{$request->search}%");
        }

        // Pagination
        $dcrs = $query->orderBy('created_at', 'desc')->paginate(10);

        // Mengirim data ke view
        return view('admin.daftarcalonrekanan.daftarcalonrekanan', compact('dcrs'));
    }

    public function storeAjax(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_dcr' => 'required|string|max:255',
                'nama_dcr' => 'required|string|max:255',
                'vendor_ids' => 'nullable|string',
            ]);

            $dcr = Dcr::create([
                'kode_dcr' => $validated['kode_dcr'],
                'nama_dcr' => $validated['nama_dcr'],
            ]);

            if (! empty($validated['vendor_ids'])) {
                $vendorIds = explode(',', $validated['vendor_ids']);
                $dcr->vendors()->sync($vendorIds);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'DCR berhasil dibuat!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan DCR.',
            ], 500);
        }
    }

    public function detail($id)
    {
        $dcr = Dcr::with('vendors')->findOrFail($id);

        return view('admin.dcr.detail', compact('dcr'));
    }

    public function create()
    {
        $vendors = Vendor::all(); // Untuk memilih vendor di modal/form

        return view('admin.dcr.create', compact('vendors'));
    }

    public function show($id)
    {
        // ambil DCR beserta vendor
        $data = Dcr::with('vendors')->findOrFail($id);

        return view('admin.daftarcalonrekanan.datacalonrekanan', compact('data'));
    }

    public function destroy($id)
    {
        try {
            $dcr = Dcr::findOrFail($id);
            $dcr->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'DCR berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus DCR.',
            ], 500);
        }
    }
}

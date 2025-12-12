<?php

namespace App\Http\Controllers;

use App\Models\SuratAdmin;
use App\Models\Vendor;
use App\Helpers\InboxHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InboxAdminController extends Controller
{
    public function index()
    {
        $data = SuratAdmin::orderBy('created_at', 'desc')->paginate(10);
        $vendors = Vendor::orderBy('nama_perusahaan')->get();

        return view('admin.inboxadmin.inboxadmin', compact('data', 'vendors'));
    }

    public function showDetail($id)
    {
        $surat = SuratAdmin::findOrFail($id);

        // ambil nama view dari helper mapping
        $viewName = InboxHelper::detailView($surat->jenis_surat);

        if (!$viewName) {
            return redirect()->route('admin.inbox')
                ->with('error', "Jenis surat tidak dikenali: {$surat->jenis_surat}");
        }

        return view("admin.inboxadmin.inboxadmindetail.$viewName", compact('surat'));
    }

    public function balasAjax(Request $request)
    {
        $request->validate([
            'id_vendor'   => 'required|exists:vendor,id_vendor',
            'id_surat'    => 'required|exists:suratadmin,id_suratadmin',
            'jenis_surat' => 'required',
            'message'     => 'required'
        ]);

        $path = $request->file ? $request->file('file')->store('suratvendor', 'public') : null;

        $nomor = "ADM-" . strtoupper(substr($request->jenis_surat, 0, 5)) . "-" . time();

        $surat = \App\Models\SuratVendor::create([
            'id_vendor'      => $request->id_vendor,
            'id_user'        => Auth::id(),
            'id_suratadmin'  => $request->id_surat,
            'nomor_surat'    => $nomor,
            'jenis_surat'    => $request->jenis_surat,
            'deskripsi'      => $request->message,
            'file_surat'     => $path,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Balasan berhasil dikirim.",
            "data" => $surat
        ]);
    }

    public function download($id)
    {
        $surat = SuratAdmin::findOrFail($id);

        if (!Storage::disk('public')->exists($surat->file_surat)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($surat->file_surat);
    }

    public function destroy($id)
    {
        SuratAdmin::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inbox berhasil dihapus.'
        ]);
    }

    public function listAjax(Request $request)
    {
        $data = SuratAdmin::orderBy('created_at', 'desc')->paginate(10);

        $rows = '';
        foreach ($data as $index => $item) {

            $detailUrl = route('admin.inbox.detail', $item->id_suratadmin);

            $rows .= '
            <tr>
                <td>'.($data->firstItem() + $index).'</td>
                <td>'.$item->nama_perusahaan.'</td>
                <td>'.$item->jenis_surat.'</td>
                <td>'.\Str::limit($item->deskripsi, 80).'</td>
                <td class="action-buttons">

                    <button class="btn btn-info btn-sm view-btn"
                        data-url="'.$detailUrl.'"
                        data-jenis="'.strtolower($item->jenis_surat).'">
                        <i class="fas fa-eye"></i>
                    </button>

                    <a href="'.route('admin.inbox.download',$item->id_suratadmin).'"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i>
                    </a>

                    <button class="btn btn-danger btn-sm delete-btn" 
                        data-id="'.$item->id_suratadmin.'">
                        <i class="fas fa-trash"></i>
                    </button>

                </td>
            </tr>';
        }

        return response()->json([
            'rows' => $rows,
            'pagination' => $data->links('pagination::bootstrap-5')->toHtml()
        ]);
    }

    public function filterAjax(Request $request)
{
    $query = SuratAdmin::query();

    if ($request->jenis) {
        $query->where('jenis_surat', $request->jenis);
    }

    if ($request->vendor) {
        $query->where('nama_perusahaan', $request->vendor);
    }

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nama_perusahaan', 'like', "%{$request->search}%")
              ->orWhere('deskripsi', 'like', "%{$request->search}%")
              ->orWhere('jenis_surat', 'like', "%{$request->search}%");
        });
    }

    $perPage = $request->per_page ?? 10;

    $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

    $rows = '';
    foreach ($data as $index => $item) {

        $detailUrl = route('admin.inbox.detail', $item->id_suratadmin);

        $rows .= '
            <tr data-jenis="'.strtolower($item->jenis_surat).'">
                <td>'.($data->firstItem() + $index).'</td>
                <td>'.$item->nama_perusahaan.'</td>
                <td>'.$item->jenis_surat.'</td>
                <td>'.\Illuminate\Support\Str::limit($item->deskripsi, 80, "...").'</td>
                <td class="action-buttons">

                    <button class="btn btn-info btn-sm view-btn"
                        data-url="'.$detailUrl.'"
                        data-jenis="'.strtolower($item->jenis_surat).'">
                        <i class="fas fa-eye"></i>
                    </button>

                    <a href="'.route('admin.inbox.download',$item->id_suratadmin).'"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i>
                    </a>

                    <button class="btn btn-danger btn-sm delete-btn" 
                        data-id="'.$item->id_suratadmin.'">
                        <i class="fas fa-trash"></i>
                    </button>

                </td>
            </tr>';
    }

    return response()->json([
        'rows' => $rows,
        'pagination' => $data->links('pagination::bootstrap-5')->toHtml()
    ]);
}

}

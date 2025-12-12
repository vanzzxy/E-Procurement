<?php

namespace App\Http\Controllers;

use App\Models\BuatKontrak;
use App\Models\BuatKontrakBarang;
use App\Models\Datakontrak;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminBerandaController extends Controller
{
    public function index()
    {
        // 1) Jumlah vendor
        $jumlahVendor = Vendor::count();

        // 2) Kontrak berjalan (contoh: status setuju / pengiriman / diterima)
        $kontrakBerjalanStatuses = ['setuju', 'pengiriman', 'diterima'];
        $kontrakBerjalan = Datakontrak::whereIn('status', $kontrakBerjalanStatuses)->count();

        // 3) Jumlah pengiriman -> datakontrak.status = 'pengiriman'
        $jumlahPengiriman = Datakontrak::where('status', 'pengiriman')->count();

        // 4) Permintaan selesai -> datakontrak.status = 'selesai'
        $permintaanSelesai = Datakontrak::where('status', 'selesai')->count();

        // 5) Grafik permintaan = jumlah unit barang per bulan (menggunakan buatkontrak & buatkontrak_barang)
        // Ambil tahun sekarang (atau bisa parameter)
        $year = Carbon::now()->year;

        // Join buatkontrak -> buatkontrak_barang, group by month of buatkontrak.created_at
        $permintaanPerBulan = BuatKontrakBarang::select(
            DB::raw('MONTH(buatkontrak.created_at) as month'),
            DB::raw('COALESCE(SUM(buatkontrak_barang.jumlah),0) as total_permintaan')
        )
            ->join('buatkontrak', 'buatkontrak.id', '=', 'buatkontrak_barang.buatkontrak_id')
            ->whereYear('buatkontrak.created_at', $year)
            ->groupBy(DB::raw('MONTH(buatkontrak.created_at)'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Prepare labels/data untuk 12 bulan
        $chartLabels = [];
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = date('M', mktime(0, 0, 0, $m, 10));
            $chartData[] = isset($permintaanPerBulan[$m]) ? (int) $permintaanPerBulan[$m]->total_permintaan : 0;
        }

        // Pemenang lelang = harga_total TERENDAH
        $pemenangLelang = Datakontrak::whereNotNull('harga_total')
            ->orderBy('harga_total', 'asc')
            ->first();

        // 7) Tabel: No, Nama Perusahaan, Jumlah Permintaan (hanya status 'selesai')
        $topPerusahaan = Datakontrak::where('status', 'selesai')
            ->select('vendor', DB::raw('COUNT(*) as jumlah_permintaan'))
            ->groupBy('vendor')
            ->orderByDesc('jumlah_permintaan')
            ->get();

        return view('admin.berandaadmin.berandaadmin', [
            'jumlahVendor' => $jumlahVendor,
            'kontrakBerjalan' => $kontrakBerjalan,
            'jumlahPengiriman' => $jumlahPengiriman,
            'permintaanSelesai' => $permintaanSelesai,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'pemenangLelang' => $pemenangLelang,
            'topPerusahaan' => $topPerusahaan,
        ]);
    }
}

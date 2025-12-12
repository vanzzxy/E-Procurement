<?php

namespace App\Http\Controllers;

use App\Models\Datakontrak;
use App\Models\SuratVendor;

class VendorBerandaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->vendor) {
            // Kalau bukan vendor (superadmin/admin)
            return redirect()->route('admin.beranda')
                ->with('error', 'Halaman ini hanya untuk vendor.');
        }

        $vendor = auth()->user()->vendor;
        $vendorId = $vendor->id_vendor;
        $vendorName = $vendor->nama_perusahaan;

        // Jumlah Penawaran Masuk (suratvendor: spphb & sph)
        $jumlahPenawaran = SuratVendor::where('id_vendor', $vendorId)
            ->whereIn('jenis_surat', ['spphb', 'sph'])
            ->count();

        // Jumlah Kontrak Berjalan berdasarkan dokumenkontrakdariadmin
        $jumlahKontrak = \App\Models\Dokumenkontrakdariadmin::where('nama_perusahaan', $vendorName)
            ->count();

        // Jumlah Pengiriman
        $jumlahPengiriman = Datakontrak::where('vendor', $vendorName)
            ->where('status', 'pengiriman')
            ->count();

        // Jumlah Permintaan Selesai
        $jumlahSelesai = Datakontrak::where('vendor', $vendorName)
            ->where('status', 'selesai')
            ->count();

        // Dropdown Kode Permintaan
        $kodePermintaan = Datakontrak::where('vendor', $vendorName)
            ->pluck('no_purchaseorder');

        // Labels bulan untuk chart
        $barChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $barChartData1 = [];
        $barChartData2 = [];

        foreach (range(1, 12) as $bulan) {
            // Penawaran per bulan
            $barChartData1[] = SuratVendor::where('id_vendor', $vendorId)
                ->whereIn('jenis_surat', ['spphb', 'sph'])
                ->whereMonth('created_at', $bulan)
                ->count();

            // Kontrak setuju per bulan
            $barChartData2[] = Datakontrak::where('vendor', $vendorName)
                ->where('status', 'setuju')
                ->whereMonth('created_at', $bulan)
                ->count();
        }

        // Pie chart: status kontrak berdasarkan kolom status
        $pieChartData = [
            'menunggu' => Datakontrak::where('vendor', $vendorName)->where('status', 'menunggu')->count(),
            'setuju' => Datakontrak::where('vendor', $vendorName)->where('status', 'setuju')->count(),
            'pengiriman' => Datakontrak::where('vendor', $vendorName)->where('status', 'pengiriman')->count(),
            'selesai' => Datakontrak::where('vendor', $vendorName)->where('status', 'selesai')->count(),
        ];

        return view('vendor.berandavendor.berandavendor', compact(
            'jumlahPenawaran',
            'jumlahKontrak',
            'jumlahPengiriman',
            'jumlahSelesai',
            'kodePermintaan',
            'barChartLabels',
            'barChartData1',
            'barChartData2',
            'pieChartData'
        ));
    }
}

@extends('vendor.layout.sidebarvendor')

@section('tittle', 'Beranda Vendor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vendor/berandavendor.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebarvendor.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .legend-color {
        display: inline-block;
        width: 15px;
        height: 15px;
        margin-right: 5px;
        border-radius: 3px;
    }
</style>
@endpush

@section('content')
<div class="main-content container-fluid">
    <h1 class="mb-4">BERANDA VENDOR</h1>

    <div class="row">
        {{-- Jumlah Penawaran Masuk --}}
        <div class="col-md-3 mb-3">
            <div class="card yellow text-center p-3">
                <h5>Jumlah Penawaran Masuk</h5>
                <h2>{{ $jumlahPenawaran ?? 0 }}</h2>
            </div>
        </div>

        {{-- Jumlah Kontrak Berjalan --}}
        <div class="col-md-3 mb-3">
            <div class="card yellow text-center p-3">
                <h5>Jumlah Kontrak Berjalan</h5>
                <h2>{{ $jumlahKontrak ?? 0 }}</h2>
            </div>
        </div>

        {{-- Proses Pengiriman --}}
        <div class="col-md-3 mb-3">
            <div class="card blue text-center p-3">
                <h5>Jumlah Pengiriman</h5>
                <h2>{{ $jumlahPengiriman ?? 0 }}</h2>
            </div>
        </div>

        {{-- Jumlah Permintaan Selesai --}}
        <div class="col-md-3 mb-3">
            <div class="card black text-center p-3">
                <h5>Jumlah Permintaan Selesai</h5>
                <h2>{{ $jumlahSelesai ?? 0 }}</h2>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row mt-4">
        {{-- Bar Chart --}}
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5 class="text-center">Statistik Penawaran & Kontrak per Bulan</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart & Dropdown --}}
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5 class="text-center">Status Kontrak</h5>
                <canvas id="pieChart"></canvas>

                <div class="mt-3 d-flex justify-content-around">
                    <div><span class="legend-color" style="background-color: #0D73FD;"></span> Upload Surat Penawaran</div>
                    <div><span class="legend-color" style="background-color: #FFB800;"></span> Negosiasi</div>
                    <div><span class="legend-color" style="background-color: #00B578;"></span> Justifikasi & Kontrak</div>
                </div>

                {{-- Dropdown Kode Permintaan --}}
                <div class="mt-4">
                    <label for="kodePermintaan">Kode Permintaan</label>
                    <select id="kodePermintaan" class="form-control">
                        <option value="">Pilih Kode Permintaan</option>
                        @foreach ($kodePermintaan as $kode)
                            <option value="{{ $kode }}">{{ $kode }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Bar Chart
var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: @json($barChartLabels),
        datasets: [
            {
                label: 'Penawaran',
                backgroundColor: '#00B578',
                data: @json($barChartData1)
            },
            {
                label: 'Kontrak Setuju',
                backgroundColor: '#FF3141',
                data: @json($barChartData2)
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Statistik Penawaran & Kontrak per Bulan' }
        },
        scales: {
            y: { beginAtZero: true, precision:0 }
        }
    }
});

// Pie Chart
var ctxPie = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Upload Surat Penawaran', 'Negosiasi', 'Justifikasi & Kontrak', 'Selesai'],
        datasets: [{
            backgroundColor: ['#0D73FD','#FFB800','#00B578','#808080'],
            data: [
                {{ $pieChartData['menunggu'] }},
                {{ $pieChartData['setuju'] }},
                {{ $pieChartData['pengiriman'] }},
                {{ $pieChartData['selesai'] }}
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            title: { display: true, text: 'Status Kontrak Vendor' }
        }
    }
});

</script>
@endpush

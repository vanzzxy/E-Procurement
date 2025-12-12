@extends('admin.layout.sidebaradmin')

@section('tittle', "Beranda Admin")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/berandaadmin.css') }}">
@endpush

@section('content')
<div class="main-content container-responsive">
    <h1 class="mt-4">Beranda Admin</h1>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-penawaran h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Jumlah Vendor</h5>
                        <h2>{{ $jumlahVendor }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-chart-line fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-negosiasi h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Kontrak Berjalan</h5>
                        <h2>{{ $kontrakBerjalan }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-handshake fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-permintaan h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Jumlah Pengiriman</h5>
                        <h2>{{ $jumlahPengiriman }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-vendor h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Permintaan Selesai</h5>
                        <h2>{{ $permintaanSelesai }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>

        <div class="col-lg-4">
<div class="card vendor-card p-3 bg-white">
    <h3>Pemenang Lelang Vendor</h3>

    @if($pemenangLelang)
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-user-circle vendor-icon"></i>
                    {{ $pemenangLelang->vendor ?? '—' }}
                </div>
                <div>
                    <span class="badge badge-secondary">
                        Rp {{ number_format($pemenangLelang->harga_total, 0, ',', '.') }}
                    </span>
                </div>
            </li>
        </ul>
    @else
        <p class="mt-2">Tidak ada pemenang lelang</p>
    @endif
</div>

    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Jumlah Permintaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPerusahaan as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->vendor }}</td>
                                <td>{{ $row->jumlah_permintaan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
        var ctx = document.getElementById('myChart').getContext('2d');

        var labels = {!! json_encode($chartLabels) !!};
        var data = {!! json_encode($chartData) !!};

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Permintaan (unit) - {{ \Carbon\Carbon::now()->year }}',
                    data: data,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    };
</script>
@endsection

@push('scripts')
@endpush

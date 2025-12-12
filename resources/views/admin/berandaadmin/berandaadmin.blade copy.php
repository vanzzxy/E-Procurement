
@extends('admin.layout.sidebaradmin')

@section('tittle', "Beranda Admin")

@push('styles')
<link rel="stylesheet" href="css/admin/berandaadmin.css">
@endpush

@section('content')
<div class="main-content container-responsive">
    <h1 class="mt-4">Beranda Admin</h1>
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-penawaran h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Penawaran</h5>
                        <h2>100</h2>
                    </div>
                    <div>
                        <i class="fas fa-chart-line fa-3x"></i> <!-- Icon untuk Penawaran -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-negosiasi h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Negosiasi Deal</h5>
                        <h2>50</h2>
                    </div>
                    <div>
                        <i class="fas fa-handshake fa-3x"></i> <!-- Icon untuk Negosiasi Deal -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-permintaan h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Permintaan Selesai</h5>
                        <h2>200</h2>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-3x"></i> <!-- Icon untuk Permintaan Selesai -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-vendor h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Vendor</h5>
                        <h2>125</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x"></i> <!-- Icon untuk Vendor -->
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
                    <h3>Pemenang Vendor Terbaru</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user-circle vendor-icon"></i>
                            PT. Angkasa Kediri Jaya <span class="badge badge-secondary">852738xxxxxxxx</span>
                        </li>
                    </ul>
                </div>
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
                        <tr>
                            <td>1</td>
                            <td>PT xxxxxx xxxxxxx xxxxx</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>PT xxxxxx xxxxxxx xxxxx</td>
                            <td>90</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- JavaScript untuk Chart -->
<script>
    window.onload = function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Permintaan',
                    data: [0, 100, 500, 400, 700, 1000, 900, 700, 600, 500, 400, 300],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    };
</script>
@endsection

@push('scripts')
@endpush

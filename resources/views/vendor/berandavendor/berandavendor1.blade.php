<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Vendor || PT.INKA Multi Solusi E-Procurement</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/vendor/berandavendor.css">
    <link rel="stylesheet" href="css/sidebarvendor.css">
</head>
@extends('vendor.layout.sidebarvendor')

@section('content')
<div class="main-content container-responsive">
    <h1>BERANDA VENDOR</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card yellow">
                <h3>Jumlah Penawaran Masuk</h3>
                <h2>10</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card yellow">
                <h3>Jumlah Kontrak Berjalan</h3>
                <h2>5</h2>
            </div>
        </div>


        <div class="col-md-6 mt-4">
            <div class="card blue">
                <h3>Proses Pengiriman</h3>
                <h2>2</h2>
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="card black">
                <h3>Jumlah Permintaan Selesai</h3>
                <h2>20</h2>
            </div>
        </div>
        
        
    </div>

    <div class="row mt-4 dashboard">
        <div class="col-md-6 card">
            <canvas id="barChart"></canvas>
        </div>
        <div class="col-md-6 card">
            <canvas id="pieChart"></canvas>
            <div class="mt-3 d-flex justify-content-around">
                    <div>
                        <span class="legend-color" style="background-color: #0D73FD;"></span>
                        Upload Surat Penawaran
                    </div>
                    <div>
                        <span class="legend-color" style="background-color: #FFB800;"></span>
                        Negosiasi
                    </div>
                    <div>
                        <span class="legend-color" style="background-color: #00B578;"></span>
                        Justifikasi & Kontrak
                    </div>
                </div>
                <div class="mt-4">
                    <label for="kodePermintaan">Kode Permintaan</label>
                    <select id="kodePermintaan" class="form-control">
                        <option value="">Pilih Kode Permintaan</option>
                        <option value="1234">1234</option>
                        <option value="5678">5678</option>
                        <option value="9101">9101</option>
                    </select>
                </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
            label: 'Dataset 1',
            backgroundColor: '#00B578',
            data: [3, 7, 4, 6, 5]
        }, {
            label: 'Dataset 2',
            backgroundColor: '#FF3141',
            data: [2, 3, 4, 1, 2]
        }]
    },
    options: {}
});

var ctxPie = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
       
        datasets : [{
            backgroundColor: ['#0D73FD', '#00B578', '#FFB800'],
            data: [10, 5, 2]
        }]
    },
    options: {}
});
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
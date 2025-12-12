@extends('vendor.layout.sidebarvendor')

@push('styles')
<link rel="stylesheet" href="css/vendor/penawaran.css">
@endpush

@section('tittle', "Penawaran")

@section('content')
<div class="main-content">
    <h1>PENAWARAN</h1>
    <div class="underline"></div>
    <div class="table-container">
        <div class="d-flex justify-content-end mb-2">
            <input type="text" class="form-control w-25" placeholder="Pencarian">
        </div>
        <table id="penawaranTable" class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>13235145</td>
                    <td>SPPHB</td>
                    <td>Reminder! Batas akhir pengiriman barang dengan kode barang</td>
                    <td>12/03/2024</td>
                    <td>
                        <a href="#" class="download"><i class="fas fa-download"></i></a>
                        <a href="#" class="view"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>15124321</td>
                    <td>SPPHB</td>
                    <td>Dokumen kontrak dengan nomor purchase order A003 telah</td>
                    <td>12/03/2024</td>
                    <td>
                        <a href="#" class="download"><i class="fas fa-download"></i></a>
                        <a href="#" class="view"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>64354322</td>
                    <td>Negosiasi</td>
                    <td>Dokumen negosiasi dari PT. INKA Multi Solusi dengan nomor surat</td>
                    <td>12/03/2024</td>
                    <td>
                        <a href="#" class="download"><i class="fas fa-download"></i></a>
                        <a href="#" class="view"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>64232124</td>
                    <td>SPPHB</td>
                    <td>Dokumen permintaan penawaran harga barang dari PT. INKA Multi</td>
                    <td>12/03/2024</td>
                    <td>
                        <a href="#" class="download"><i class="fas fa-download"></i></a>
                        <a href="#" class="view"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <button class="prev-btn">Previous</button>
            <span>Page 1 of 3</span>
            <button class="next-btn">Next</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    var viewIcons = document.querySelectorAll('.view');
    viewIcons.forEach(function(icon) {
        icon.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = 'penawarandetail';
        });
    });
</script>

@endpush

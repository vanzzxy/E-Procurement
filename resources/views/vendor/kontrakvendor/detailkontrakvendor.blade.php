@extends('vendor.layout.sidebarvendor')

@section('content')
<div class="main-content">
    <h1 class="section-title">DETAIL KONTRAK VENDOR</h1>

    <div class="info-box">
        <p><strong>No Purchase Order:</strong> {{ $kontrak->no_purchaseorder }}</p>
        <p><strong>Nama Perusahaan:</strong> {{ $kontrak->nama_perusahaan }}</p>
        <p><strong>Kategori Barang:</strong> {{ $kontrak->kategori_barang }}</p>
        <p><strong>Deadline:</strong> {{ $buatKontrak->deadline ? \Carbon\Carbon::parse($buatKontrak->deadline)->format('d/m/Y') : '-' }}</p>
        <p><strong>Jenis Surat:</strong> {{ $kontrak->jenis_surat }}</p>
    </div>

    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Item</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Spesifikasi</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $i)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $i->id }}</td>
                    <td>{{ $i->kode_barang }}</td>
                    <td>{{ $i->nama_barang }}</td>
                    <td>{{ $i->spesifikasi }}</td>
                    <td>{{ $i->jumlah }}</td>
                    <td>Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
                    <td>{{ $i->satuan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if(count($items) == 0)
        <div class="alert alert-warning mt-3">
            Tidak ada item barang pada kontrak ini.
        </div>
        @endif
    </div>

    <a href="{{ route('vendor.kontrak') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@endsection

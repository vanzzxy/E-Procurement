@extends('vendor.layout.sidebarvendor')

@section('content')
<div class="main-content p-4">
    <h1 class="mb-4">Detail Kontrak: {{ $kontrak->no_purchaseorder }}</h1>

    <div class="card p-3 mb-4">
        <h4>Informasi Kontrak</h4>
        <p><strong>No PO:</strong> {{ $kontrak->no_purchaseorder }}</p>
        <p><strong>Vendor:</strong> {{ $kontrak->vendor }}</p>
        <p><strong>Kategori Barang:</strong> {{ $kontrak->kategori_barang }}</p>
        <p><strong>Harga Total:</strong> {{ number_format($kontrak->harga_total,0,',','.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($kontrak->status) }}</p>
    </div>

    <h4>Daftar Barang</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $i => $b)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $b->masterbarang->nama_barang ?? 'N/A' }}</td>
                <td>{{ $b->jumlah }}</td>
                <td>{{ number_format($b->harga,0,',','.') }}</td>
                <td>{{ number_format($b->subtotal,0,',','.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('vendor.riwayatmasuk') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

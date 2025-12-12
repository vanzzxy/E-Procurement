@extends('vendor.layout.sidebarvendor')

@section('tittle', 'Detail Pengiriman Vendor')

@section('content')
<div class="main-content p-4">
    <h3 class="mb-4">Detail Pengiriman Barang</h3>

    <div class="card mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nomor Surat Jalan</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->nomor_surat_jalan }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Armada</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->armada }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>No. Polisi Armada</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->no_polisi }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Sopir</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->nama_sopir }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Telepon Sopir</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->telepon_sopir }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Tanggal Pengiriman</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->created_at->format('d/m/Y') }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Dokumen Surat Jalan</label>
                @if($pengiriman->file_suratjalan)
                    <div class="file-preview d-flex align-items-center justify-content-between p-2 border rounded">
                        <span>{{ basename($pengiriman->file_suratjalan) }}</span>
                        <div>
                            <a href="{{ asset('storage/'.$pengiriman->file_suratjalan) }}" download class="btn btn-link p-0 mr-2">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="{{ asset('storage/'.$pengiriman->file_suratjalan) }}" target="_blank" class="btn btn-link p-0">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <span class="text-muted">Belum ada dokumen</span>
                @endif
            </div>
        </div>
    </div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Tabel Detail Pengiriman Barang</h5>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
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
@forelse ($barangList as $index => $item)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $item->id }}</td>
    <td>{{ $item->masterbarang->kode_barang ?? '-' }}</td>
    <td>{{ $item->masterbarang->nama_barang ?? '-' }}</td>
    <td>{{ $item->masterbarang->spesifikasi ?? '-' }}</td>
    <td>{{ $item->jumlah }}</td>
    <td>{{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
    <td>{{ $item->masterbarang->satuan ?? '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">Tidak ada barang</td>
</tr>
@endforelse
</tbody>

            </table>
        </div>

    </div>
</div>

</div>
@endsection

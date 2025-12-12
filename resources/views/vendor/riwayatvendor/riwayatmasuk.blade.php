@extends('vendor.layout.sidebarvendor')

@section('content')
<div class="main-content p-4">
    <h1 class="mb-4">Riwayat Surat Masuk</h1>

    <!-- Filters -->
    <form method="GET" class="card p-3 mb-4 filter-card">
        <div class="row g-3">
            <!-- No Purchase Order -->
            <div class="col-md-2">
                <label>No Purchase Order</label>
                <input type="text" name="no_po" class="form-control" value="{{ request('no_po') }}" placeholder="Cari No PO...">
            </div>

            <!-- Kategori Barang -->
            <div class="col-md-2">
                <label>Kategori Barang</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    <option value="Tools" @selected(request('kategori') == 'Tools')>Tools</option>
                    <option value="Consumable" @selected(request('kategori') == 'Consumable')>Consumable</option>
                    <option value="Material" @selected(request('kategori') == 'Material')>Material</option>
                    <option value="Raw Material" @selected(request('kategori') == 'Raw Material')>Raw Material</option>
                </select>
            </div>

            <!-- Status -->
            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="menunggu" @selected(request('status') == 'menunggu')>Menunggu</option>
                    <option value="setuju" @selected(request('status') == 'setuju')>Setuju</option>
                    <option value="pengiriman" @selected(request('status') == 'pengiriman')>Pengiriman</option>
                    <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
                    <option value="diterima" @selected(request('status') == 'diterima')>Diterima</option>
                </select>
            </div>

            <!-- Jenis Surat -->
            <div class="col-md-2">
                <label>Jenis Surat</label>
                <select name="jenis_surat" class="form-control">
                    <option value="">Semua</option>
                    @foreach($jenisSurat as $jenis)
                        <option value="{{ $jenis }}" @selected(request('jenis_surat') == $jenis)>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-2 d-flex align-items-end">
                <div class="action-buttons w-100">
                    <button type="submit" class="btn btn-primary w-100 mb-2">Filter</button>
                    <a href="{{ route('vendor.riwayatmasuk') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel 1: Datakontrak -->
    <h3>Data Kontrak Masuk</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Purchase Order</th>
                <th>Kategori Barang</th>
                <th>Vendor</th>
                <th>Harga Total</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datakontrak as $i => $kontrak)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $kontrak->no_purchaseorder }}</td>
                <td>{{ $kontrak->kategori_barang }}</td>
                <td>{{ $kontrak->vendor }}</td>
                <td>{{ number_format($kontrak->harga_total,0,',','.') }}</td>
                <td>{{ ucfirst($kontrak->status) }}</td>
                <td>{{ $kontrak->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('vendor.datakontrak.detail', $kontrak->id) }}" class="btn btn-info btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabel 2: Suratvendor -->
    <h3>Surat Vendor Masuk</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Jenis Surat</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratVendor as $i => $surat)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->jenis_surat }}</td>
                <td>{{ $surat->deskripsi }}</td>
                <td>{{ $surat->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($surat->file_surat)
                    <a href="{{ asset('storage/'.$surat->file_surat) }}" class="btn btn-success btn-sm" download>
                        Download
                    </a>
                    @else
                    <span class="text-muted">Tidak ada file</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
/* Tambahkan jarak dalam card filter */
.filter-card {
    padding: 20px; /* jarak dari pinggir card */
}

/* Jarak antar tombol filter dan reset */
.action-buttons .btn {
    margin-bottom: 10px; /* jarak vertikal */
}

/* Untuk layar besar, jika tombol sejajar horizontal */
@media(min-width: 768px) {
    .action-buttons.d-flex .btn {
        margin-right: 10px;
    }
    .action-buttons.d-flex .btn:last-child {
        margin-right: 0;
    }
}
</style>

@endsection

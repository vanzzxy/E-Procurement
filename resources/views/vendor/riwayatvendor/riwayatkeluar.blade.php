@extends('vendor.layout.sidebarvendor')

@push('styles')
<style>
/* Jarak dari pinggir card */
.filter-card {
    padding: 20px; /* atau sesuai kebutuhan */
}

/* Jarak antar tombol */
.action-buttons .btn {
    margin-bottom: 10px; /* Jarak vertikal antar tombol jika stack */
}

/* Jika horizontal (tidak stack) gunakan margin-right */
.action-buttons.d-flex .btn {
    margin-right: 10px;
}

.action-buttons.d-flex .btn:last-child {
    margin-right: 0;
}
</style>
@endpush

@section('content')
<div class="main-content p-4">
    <h1 class="mb-4">Riwayat Surat Keluar</h1>

    <!-- Card Filter -->
    <form method="GET" class="card p-3 mb-4 filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Jenis Surat (Surat Admin)</label>
                <select name="jenis" class="form-control">
                    <option value="">Semua</option>
                    @foreach($jenisSurat as $jenis)
                        <option value="{{ $jenis }}" @selected(request('jenis') == $jenis)>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label>Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <label>No Purchase Order</label>
                <input type="text" name="no_po" class="form-control" value="{{ request('no_po') }}" placeholder="Cari No PO...">
            </div>
            <div class="col-md-2">
                <label>No Surat Jalan</label>
                <input type="text" name="no_surat_jalan" class="form-control" value="{{ request('no_surat_jalan') }}" placeholder="Cari No SJ...">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <div class="action-buttons w-100">
                    <button type="submit" class="btn btn-primary w-100 mb-2">Filter</button>
                    <a href="{{ route('vendor.riwayatkeluar') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel Surat Admin -->
    <h3>Surat Admin</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratAdmin as $i => $surat)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $surat->nama_perusahaan }}</td>
                <td>{{ $surat->jenis_surat }}</td>
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
                <td colspan="5" class="text-center">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabel Pengiriman Vendor -->
    <h3>Pengiriman Vendor</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Purchase Order</th>
                <th>Nomor Surat Jalan</th>
                <th>Nama Sopir</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengiriman as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->no_purchaseorder }}</td>
                <td>{{ $p->nomor_surat_jalan }}</td>
                <td>{{ $p->nama_sopir }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($p->file_suratjalan)
                    <a href="{{ asset('storage/'.$p->file_suratjalan) }}" class="btn btn-success btn-sm" download>
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
@endsection

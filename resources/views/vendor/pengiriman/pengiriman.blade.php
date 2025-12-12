@extends('vendor.layout.sidebarvendor')

@section('tittle', 'Pengiriman Vendor')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-header d-flex align-items-center mb-4">
        <h3 class="m-0">Pengiriman Vendor</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    <div class="d-flex align-items-center justify-content-end mb-3">
        <div class="input-group" style="width: 300px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Pencarian">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" onclick="filterTable()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <button class="btn btn-primary ml-3" onclick="window.location.href='{{ route('vendor.pengiriman.tambah') }}'">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="pengirimanTable">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nomor Surat Jalan</th>
                    <th>No. PO</th>
                    <th>No. Polisi</th>
                    <th>Nama Sopir</th>
                    <th>Telepon Sopir</th>
                    <th>Armada</th>
                    <th>File Surat Jalan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengiriman as $key => $row)
                <tr class="text-center">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->nomor_surat_jalan }}</td>
                    <td>{{ $row->no_purchaseorder }}</td>
                    <td>{{ $row->no_polisi }}</td>
                    <td>{{ $row->nama_sopir }}</td>
                    <td>{{ $row->telepon_sopir }}</td>
                    <td>{{ $row->armada }}</td>
                    <td>
                        @if($row->file_suratjalan)
                        <a href="{{ asset('storage/' . $row->file_suratjalan) }}" target="_blank">Lihat File</a>
                        @else
                        -
                        @endif
                    </td>
                    <td class="status-cell">
                        @php 
    $status = $row->datakontrak->status ?? 'pengiriman';
@endphp

@include('vendor.layout.status_badge', [
    'status' => $status,
    'id' => $row->id   // ← DITAMBAHKAN
])                    </td>
<td>
    <a href="{{ route('vendor.pengiriman.detailModal', $row->id) }}" class="btn btn-sm btn-info">Detail</a>

    <button class="btn btn-sm btn-success btn-selesai" data-id="{{ $row->id }}">
        Selesai
    </button>

    <form action="{{ route('vendor.pengiriman.hapus', $row->id) }}" 
          method="POST" 
          class="d-inline"
          onsubmit="return confirm('Yakin ingin menghapus pengiriman ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
    </form>
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data pengiriman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function filterTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#pengirimanTable tbody tr");
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}

// AJAX untuk update status selesai
$(document).ready(function(){
    $('.btn-selesai').click(function(){
        if(!confirm('Yakin pengiriman ini sudah selesai?')) return;
        let btn = $(this);
        let id = btn.data('id');

        $.ajax({
            url: '/vendor/pengiriman/selesai/' + id,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(){
                let statusCell = btn.closest('tr').find('.status-cell');
                statusCell.html('<span class="badge badge-success">Selesai</span>');
            },
            error: function(){
                alert('Gagal mengubah status!');
            }
        });
    });
});

// AJAX Hapus Pengiriman
$(document).on('click', '.btn-hapus', function(){
    if(!confirm('Yakin ingin menghapus data pengiriman ini?')) return;

    let btn = $(this);
    let id = btn.data('id');

    $.ajax({
        url: '/vendor/pengiriman/hapus/' + id,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function(){
            btn.closest('tr').fadeOut();
        },
        error: function(){
            alert('Gagal menghapus data!');
        }
    });
});

</script>
@endpush

@extends('admin.layout.sidebaradmin')

@section('tittle', 'Pengiriman Admin')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-header d-flex align-items-center mb-4">

        <h3 class="m-0">Pengiriman</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="d-flex align-items-center justify-content-end mb-3">
        <div class="input-group" style="width: 300px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Pencarian">
            <button class="btn btn-outline-secondary" type="button" onclick="filterTable()">
                <i class="fas fa-search"></i>
            </button>
        </div>
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
@include('admin.layout.status_badge', [
    'status' => $status,
    'id' => $row->id   // ← DITAMBAHKAN
])

                    </td>
                    <td>
                        <a href="{{ route('admin.pengirimanadmin.detailModal', $row->id) }}" class="btn btn-sm btn-info">Detail</a>
@php 
    $status = $row->datakontrak->status ?? 'pengiriman';
    $disabled = in_array($status, ['selesai', 'diterima']); 
@endphp

<button 
    class="btn btn-sm btn-success btn-diterima" 
    data-id="{{ $row->id }}"
    {{ $disabled ? 'disabled' : '' }}
>
    {{ $disabled ? 'Sudah Diterima' : 'Diterima' }}
</button>


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

$(document).ready(function(){
    $('.btn-diterima').click(function () {
        if ($(this).prop('disabled')) return;

        if (!confirm('Yakin ingin menandai pengiriman ini sebagai diterima?')) return;

        let btn = $(this);
        let id = btn.data('id');

        $.ajax({
            url: "{{ url('admin/pengiriman/diterima') }}/" + id,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response){

                // UPDATE BADGE LANGSUNG
                $("#status-badge-" + id)
                    .removeClass()
                    .addClass("badge bg-info text-dark")
                    .text("Diterima");

                // DISABLE TOMBOL
                btn.prop('disabled', true).text('Sudah Diterima');
            },
            error: function(){
                alert('Gagal mengubah status!');
            }
        });
    });
});


</script>
@endpush

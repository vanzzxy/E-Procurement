@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/daftarcalonrekanan.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Daftar Calon Rekanan")

@section('content')
<div class="main-content">
    <h1>DAFTAR CALON REKANAN</h1>
    <div class="underline"></div>

    <div class="table-container">
        <table id="dcrTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode DCR</th>
                    <th>Nama DCR</th>
                    <th>Tanggal Dibuat</th>
                    <th style="width:130px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dcrs as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode_dcr }}</td>
                    <td>{{ $item->nama_dcr }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center gap-2">
                        {{-- Tombol Lihat --}}
                        <a href="{{ route('dcr.show', $item->id_dcr) }}" class="btn btn-sm text-dark" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        {{-- Tombol Hapus --}}
                        <button class="btn btn-sm text-danger" title="Hapus" onclick="deleteDcr({{ $item->id_dcr }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-danger">Tidak ada data ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 1500,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
});
</script>
@endif

<script>
$(document).ready(function() {
    var table = $('#dcrTable').DataTable({
        "pageLength": 10,
        "order": [[0, "asc"]],
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
            "zeroRecords": "Tidak ada data ditemukan"
        }
    });

    // fungsi hapus
    window.deleteDcr = function(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data DCR ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("dcr.destroy", ":id") }}'.replace(':id', id),
                    type: 'POST',
                    data: { 
                        _method: 'DELETE', 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: response.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // reload tabel tanpa reload halaman
                        table.row($("button[onclick='deleteDcr("+id+")']").parents('tr')).remove().draw();
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    };
});
</script>


{{-- SweetAlert pesan sukses/gagal dari session --}}

@endpush

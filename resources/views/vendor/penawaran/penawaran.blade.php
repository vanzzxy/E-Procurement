@extends('vendor.layout.sidebarvendor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vendor/penawaran.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Penawaran")

@section('content')
<div class="main-content">
    <h1>PENAWARAN</h1>
    <div class="underline"></div>

    <div class="table-container">
        <table id="penawaranTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th style="width:130px;">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($data as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->nomor_surat }}</td>
                    <td>{{ $row->jenis_surat }}</td>
                    <td>{{ Str::limit($row->deskripsi, 100, '...') }}</td>
                    <td>{{ $row->created_at ? $row->created_at->format('d/m/Y') : '-' }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center gap-2">
                        <a href="{{ route('vendor.penawaran.download', ['id' => $row->id_surat]) }}" 
                        class="text-success" title="Download">
                            <i class="fas fa-download"></i>
                        </a>

                        <a href="{{ route('vendor.penawaran.detail', ['id' => $row->id_surat]) }}" 
                        class="text-primary" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="javascript:void(0);" 
                        class="text-danger" 
                        title="Hapus" 
                        onclick="deleteSurat({{ $row->id_surat }})">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">Belum ada dokumen penawaran</td>
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

<script>
$(document).ready(function() {
    $('#penawaranTable').DataTable({
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
});
</script>

<script>
function deleteSurat(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data surat akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("vendor.penawaran.delete", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if(res.success){
                        Swal.fire('Terhapus!', res.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Gagal!', res.message, 'error');
                    }
                },
                error: function(xhr){
                    console.error(xhr.responseText);
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            });
        }
    });
}
</script>
@endpush

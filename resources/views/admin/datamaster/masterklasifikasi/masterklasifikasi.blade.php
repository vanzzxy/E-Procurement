@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/masterklasifikasi.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Master Klasifikasi")

@section('content')
<div class="main-content">
    <h1>MASTER KLASIFIKASI</h1>
    <div class="underline"></div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Klasifikasi
        </button>
    </div>

    <div class="table-container">
        <table id="klasifikasiTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Klasifikasi</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th style="width:130px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_klasifikasi }}</td>
                        <td>{{ $row->nama_klasifikasi }}</td>
                        <td>{{ $row->keterangan }}</td>
                        <td class="text-center d-flex justify-content-center align-items-center gap-2">

                            {{-- Tombol Edit --}}
                            <button class="btn btn-sm text-dark" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $row->id_klasifikasi }}" 
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <button class="btn btn-sm text-danger" 
                                title="Hapus" 
                                onclick="deleteKlasifikasi('{{ $row->id_klasifikasi }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $row->id_klasifikasi }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('masterklasifikasi.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Klasifikasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="old_id" value="{{ $row->id_klasifikasi }}">
                                        <div class="mb-3">
                                            <label>ID Klasifikasi</label>
                                            <input type="text" name="id_klasifikasi" class="form-control"   pattern="\d+" title="ID Klasifikasi harus berupa angka!" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Klasifikasi</label>
                                            <input type="text" name="nama_klasifikasi" value="{{ $row->nama_klasifikasi }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Keterangan</label>
                                            <textarea name="keterangan" class="form-control">{{ $row->keterangan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-dark">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger">Belum ada data klasifikasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('masterklasifikasi.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>ID Klasifikasi</label>
                        <input type="text" name="id_klasifikasi" class="form-control"   pattern="\d+" title="ID Klasifikasi harus berupa angka!" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Klasifikasi</label>
                        <input type="text" name="nama_klasifikasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#klasifikasiTable').DataTable({
        "pageLength": 10,
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

function deleteKlasifikasi(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data klasifikasi ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("masterklasifikasi.delete", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data klasifikasi berhasil dihapus.',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1000);
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
}
</script>

{{-- SweetAlert dari session --}}
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
@endpush

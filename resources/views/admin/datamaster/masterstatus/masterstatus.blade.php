@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/masterstatus.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Master Status")

@section('content')
<div class="main-content">
    <h1>MASTER STATUS</h1>
    <div class="underline"></div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Status
        </button>
    </div>

    <div class="table-container">
        <table id="statusTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Klasifikasi</th>
                    <th>Nama Klasifikasi</th>
                    <th>Status</th>
                    <th>Keterangan Status</th>
                    <th style="width:130px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->id_klasifikasi }}</td>
                    <td>{{ $row->klasifikasi->nama_klasifikasi ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $row->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                    <td>{{ $row->keterangan_status }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center gap-2">
                        {{-- Tombol Edit --}}
                        <button class="btn btn-sm text-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $row->id_status }}"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>

                        {{-- Tombol Hapus --}}
                        <button class="btn btn-sm text-danger"
                            title="Hapus"
                            onclick="deleteStatus({{ $row->id_status }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $row->id_status }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('masterstatus.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_status" value="{{ $row->id_status }}">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Klasifikasi</label>
                                        <input type="text" value="{{ $row->id_klasifikasi }} - {{ $row->klasifikasi->nama_klasifikasi ?? '-' }}" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <input type="text" name="status" value="{{ $row->status }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Keterangan Status</label>
                                        <textarea name="keterangan_status" class="form-control" required>{{ $row->keterangan_status }}</textarea>
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
                    <td colspan="6" class="text-center text-danger">Belum ada data status</td>
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
            <form action="{{ route('masterstatus.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Klasifikasi</label>
                        <select name="id_klasifikasi" class="form-select" required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            @foreach($klasifikasi as $k)
                                <option value="{{ $k->id_klasifikasi }}">
                                    {{ $k->id_klasifikasi }} - {{ $k->nama_klasifikasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan Status</label>
                        <textarea name="keterangan_status" class="form-control" required></textarea>
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
    $('#statusTable').DataTable({
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

// SweetAlert Konfirmasi Hapus
function deleteStatus(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data status ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("masterstatus.delete", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data status berhasil dihapus.',
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

{{-- SweetAlert Pesan dari Session --}}
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

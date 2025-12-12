@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/masterbarang.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Master Barang")

@section('content')
<div class="main-content">
    <h1>MASTER BARANG</h1>
    <div class="underline"></div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Barang
        </button>
    </div>

    <div class="table-container">
        <table id="barangTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Spesifikasi</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th style="width:130px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barang as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->dataMaster->nama_master ?? '-' }}</td>
                        <td>{{ Str::limit($item->spesifikasi, 100, '...') }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center d-flex justify-content-center align-items-center gap-2">
                            {{-- Tombol Edit --}}
                            <button class="btn btn-sm text-dark" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $item->id_masterbarang }}" 
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <button class="btn btn-sm text-danger" title="Hapus" onclick="deleteBarang({{ $item->id_masterbarang }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $item->id_masterbarang }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id_masterbarang }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('masterbarang.update', $item->id_masterbarang) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Kode Barang</label>
                                            <input type="text" name="kode_barang" value="{{ $item->kode_barang }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Barang</label>
                                            <input type="text" name="nama_barang" value="{{ $item->nama_barang }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kategori</label>
                                            <select name="data_master_id" class="form-select" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($dataMaster as $dm)
                                                    <option value="{{ $dm->id_master }}" {{ $item->data_master_id == $dm->id_master ? 'selected' : '' }}>
                                                        {{ $dm->nama_master }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Spesifikasi</label>
                                            <textarea name="spesifikasi" class="form-control">{{ $item->spesifikasi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Satuan</label>
                                            <input type="text" name="satuan" value="{{ $item->satuan }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-select">
                                                <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Nonaktif" {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
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
                        <td colspan="8" class="text-center text-danger">Belum ada data barang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('masterbarang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="data_master_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($dataMaster as $dm)
                                <option value="{{ $dm->id_master }}">{{ $dm->nama_master }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Satuan</label>
                        <input type="text" name="satuan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
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
    $('#barangTable').DataTable({
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

{{-- SweetAlert Konfirmasi Hapus --}}
<script>
function deleteBarang(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data barang ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("masterbarang.delete", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data barang berhasil dihapus.',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
}
</script>

{{-- SweetAlert untuk pesan sukses/gagal dari session --}}
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

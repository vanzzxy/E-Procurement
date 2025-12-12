@extends('admin.layout.sidebaradmin')

@section('tittle', "Daftar Kontrak || PT.INKA Multi Solusi E-Procurement")

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-3">Daftar Kontrak</h4>

    <form class="d-flex justify-content-end mb-3" method="GET" action="{{ route('buatkontrak.index') }}">
        <input type="text" name="search" class="form-control w-25" placeholder="Pencarian" value="{{ request('search') }}">
        <button class="btn btn-light ml-2"><i class="fas fa-search"></i></button>
    </form>

    @if($kontraks->isEmpty())
        <p class="text-center">Belum ada kontrak</p>
    @else
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No. PO</th>
                    <th>Nama Perusahaan</th>
                    <th>Kategori Barang</th>
                    <th>Harga Total</th>
                    <th>Deadline</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kontraks as $kontrak)
                <tr id="row-{{ $kontrak->id }}">
                    <td>{{ $kontrak->no_purchaseorder }}</td>
                    <td>{{ $kontrak->vendor->nama_perusahaan ?? '-' }}</td>
                    <td>{{ $kontrak->kategori_barang ?? '-' }}</td>
                    <td>{{ $kontrak->harga_total ? 'Rp '.number_format($kontrak->harga_total,0,',','.') : '-' }}</td>
                    <td>{{ $kontrak->deadline ? \Carbon\Carbon::parse($kontrak->deadline)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">
                        <!-- Tombol Detail -->
                        <a href="{{ route('buatkontrak.detail', $kontrak->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <!-- Tombol Upload -->
                        <form action="{{ route('buatkontrak.upload', $kontrak->id) }}" method="POST" class="d-inline form-upload">
                            @csrf
                            <button type="button" class="btn btn-sm btn-success btn-upload">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </form>

                        <!-- Tombol Delete AJAX -->
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $kontrak->id }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // Upload SweetAlert
    $('.btn-upload').on('click', function(e){
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Upload Kontrak?',
            text: 'Data kontrak akan diupload, pastikan detail data sudah benar.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, upload!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6'
        }).then(result => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });

    // Delete SweetAlert + AJAX
    $('.btn-delete').on('click', function(e){
        e.preventDefault();
        let kontrakId = $(this).data('id');
        let row = $('#row-' + kontrakId);

        Swal.fire({
            title: 'Hapus Kontrak?',
            text: 'Kontrak dan barang terkait akan dihapus, tetapi data upload tetap aman.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then(result => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/buatkontrak/' + kontrakId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        Swal.fire('Terhapus!', 'Kontrak berhasil dihapus.', 'success');
                        row.fadeOut(500, function(){ $(this).remove(); });
                    },
                    error: function(){
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                    }
                });
            }
        });
    });

});
</script>
@endpush

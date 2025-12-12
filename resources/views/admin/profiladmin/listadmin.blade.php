@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')

<div class="container mt-4">

    <h2>Daftar Admin</h2>

    <table class="table table-bordered mt-4 align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Foto</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>

<tbody id="adminTableBody">
    @foreach($admins as $a)
    <tr class="text-center" id="admin-row-{{ $a->id_user }}">
        <td>
            <img src="{{ $a->photo ? asset('uploads/admin/'.$a->photo) : asset('img/default-user.png') }}"
                width="80" height="80" style="object-fit:cover; border-radius:50%; border:2px solid #ddd;">
        </td>
        <td>{{ $a->username }}</td>
        <td>{{ $a->email }}</td>
        <td>{{ ucfirst($a->role) }}</td>
        <td>
            <button class="btn btn-danger btn-sm delete-admin-btn" data-id="{{ $a->id_user }}">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </td>
    </tr>
    @endforeach
</tbody>

    </table>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
$(document).ready(function(){

    $('.delete-admin-btn').click(function(){
        let adminId = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus admin ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){

                $.ajax({
                    url: '/profiladmin/delete/' + adminId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response){
                        // Jika berhasil, hapus row dari tabel
                        if(response.status == 'success'){
                            $('#admin-row-' + adminId).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });

            }
        });

    });

});
</script>
@endpush

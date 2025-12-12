@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/inboxadmin.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
/* Search bar */
.search-bar {
    max-width: 300px;
    margin-bottom: 15px;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
.action-buttons .btn {
    min-width: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0.25rem 0.5rem;
}

/* Responsive */
@media (max-width: 576px) {
    .action-buttons {
        gap: 2px;
    }
    .action-buttons .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.8rem;
    }
}

/* Pagination wrapper */
.pagination-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    padding-bottom: 5px;
}

/* Pagination styling */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 10px 0;
    gap: 5px;
    white-space: nowrap;
}

.pagination li {
    display: inline-block;
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 6px 12px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s ease;
}

.pagination a:hover {
    background-color: #007bff;
    color: white;
}

.pagination .active span {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination .disabled span {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.pagination svg {
    width: 14px;
    height: 14px;
    vertical-align: middle;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">INBOX</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-box"></i> Semua Inbox
                    </div>

                    <div class="d-flex gap-2 flex-wrap">

                        <select id="filterJenis" class="form-control form-control-sm" style="max-width:150px;">
                            <option value="">Semua Jenis</option>
                            <option value="sph">SPH</option>
                            <option value="spb">SPB</option>
                            <option value="spphb">SPPHB</option>
                            <option value="setuju">Setuju</option>
                            <option value="kontrak">Kontrak</option>
                            <option value="pengiriman">Pengiriman</option>
                            <option value="tidak setuju">Tidak Setuju</option>
                            <option value="negosiasi">Negosiasi</option>

                        </select>

                        <select name="id_vendor" id="vendorSelect" class="form-control form-control-sm" style="min-width:180px;">
                            <option value="">Semua Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->nama_perusahaan }}">{{ $vendor->nama_perusahaan }}</option>
                            @endforeach
                        </select>

                        <input type="text" id="searchInput" class="form-control form-control-sm search-bar" placeholder="Cari inbox...">

                        <select id="perPageSelect" class="form-control form-control-sm" style="max-width:80px;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
<button id="filterBtn" class="btn btn-primary btn-sm">
    <i class="fas fa-filter"></i> Filter
</button>

<button id="resetBtn" class="btn btn-secondary btn-sm">
    <i class="fas fa-undo"></i> Reset
</button>

                    </div>
                </div>


                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Jenis Surat</th>
                                    <th>Deskripsi</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $item)
                                    <tr data-jenis="{{ strtolower($item->jenis_surat) }}">

@php
    $routeDetail = route('admin.inbox.detail', $item->id_suratadmin);
@endphp


                                        <td>{{ $data->firstItem() + $index }}</td>
                                        <td>{{ $item->nama_perusahaan }}</td>
                                        <td>{{ $item->jenis_surat }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80, '...') }}</td>

                                        <td class="action-buttons">

                                            <button class="btn btn-sm btn-info view-btn"
                                                    data-jenis="{{ strtolower($item->jenis_surat) }}"
                                                    data-url="{{ $routeDetail }}"
                                                    title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.inbox.download', $item->id_suratadmin) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            <button class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $item->id_suratadmin }}" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-center pagination-wrapper">
                    {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$('#vendorSelect').select2({ width: '100%', placeholder: "Cari vendor...", allowClear: true });
</script>

<script>
/* ===========================
   SWEET ALERT KHUSUS TIDAK SETUJU
   =========================== */
$(document).on('click', '.view-btn', function () {

    const jenis = $(this).data('jenis');
    const url = $(this).data('url');

    // Jika surat TIDAK SETUJU → munculkan warning
    if (jenis === "tidak setuju") {

        Swal.fire({
            title: "Status vendor tidak setuju",
            text: "Apakah ingin mengajukan negosiasi?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });

    } else {
        // Selain tidak setuju → langsung masuk detail
        window.location.href = url;
    }
});
</script>

<script>
    /* ===========================
   DELETE INBOX (AJAX)
   =========================== */
$(document).on('click', '.delete-btn', function () {

    const id = $(this).data('id');

    Swal.fire({
        title: "Hapus Inbox?",
        text: "Data tidak bisa dikembalikan setelah dihapus.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "/admin/inbox/" + id,     // pastikan route benar
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {

                    if (response.success) {

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            timer: 1300,
                            showConfirmButton: false
                        });

                        // reload halaman atau row saja
                        location.reload();
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan server."
                    });
                }
            });

        }
    });
});

</script>

<script>
$("#filterBtn").on("click", function() {
    let jenis = $("#filterJenis").val();
    let vendor = $("#vendorSelect").val();
    let search = $("#searchInput").val();
    let perPage = $("#perPageSelect").val();

    $.ajax({
        url: "{{ route('admin.inbox.filter') }}",
        type: "GET",
        data: {
            jenis: jenis,
            vendor: vendor,
            search: search,
            per_page: perPage
        },
        success: function(res) {
            $("#dataTable tbody").html(res.rows);
            $(".pagination-wrapper").html(res.pagination);
        },
        error: function() {
            Swal.fire("Error", "Gagal memuat filter.", "error");
        }
    });
});

/* RESET FILTER */
$("#resetBtn").on("click", function() {
    $("#filterJenis").val("");
    $("#vendorSelect").val("").trigger("change");
    $("#searchInput").val("");
    $("#perPageSelect").val("10");

    $("#filterBtn").click(); // reload tabel
});
</script>

@endpush

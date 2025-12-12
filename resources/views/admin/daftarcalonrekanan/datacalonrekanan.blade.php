@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/datacalonrekanan.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('tittle', "Data Calon Rekanan")

@section('content')

<div class="main-content">
    <h1>DATA CALON REKANAN</h1>
    <div class="underline"></div>

    <div class="highlight mb-3">
        {{ $data->kode_dcr }} - {{ $data->nama_dcr }}
    </div>

    <div class="table-container">
        <table id="rekananTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Vendor</th>
                    <th>Nama Perusahaan</th>
                    <th>Tools</th>
                    <th>Consumable</th>
                    <th>Material</th>
                    <th>Raw Material</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data->vendors as $index => $vendor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vendor->id_vendor }}</td>
                    <td>{{ $vendor->nama_perusahaan }}</td>
                    <td>{!! in_array('Tools', json_decode($vendor->kategori_perusahaan ?? '[]')) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                    <td>{!! in_array('Consumable', json_decode($vendor->kategori_perusahaan ?? '[]')) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                    <td>{!! in_array('Material', json_decode($vendor->kategori_perusahaan ?? '[]')) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                    <td>{!! in_array('Raw Material', json_decode($vendor->kategori_perusahaan ?? '[]')) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}</td>
                    <td class="text-center d-flex justify-content-center align-items-center gap-3">
                        <a href="{{ route('admin.detaildatavendor', $vendor->id_vendor) }}" class="text-primary" title="Detail">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-success" title="Upload Surat" onclick="openUploadModal({{ $vendor->id_vendor }})">
                            <i class="fa fa-upload"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-danger">Tidak ada data vendor</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ========= MODAL UPLOAD ========= -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Unggah Dokumen Penawaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup" onclick="$('#uploadModal').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="vendor_id" id="vendor_id">

                <div class="modal-body">
                    <div id="dropZone" class="border border-secondary rounded text-center p-4 mb-3" style="cursor:pointer;">
                        <i class="fa fa-upload text-success" style="font-size:25px;"></i>
                        <p class="m-0">Seret & letakkan file di sini atau klik untuk memilih file</p>
                        <input type="file" name="file_surat" id="fileInput" hidden>
                        <p id="fileName" class="mt-2 font-weight-bold text-primary"></p>
                        <img id="imgPreview" src="" class="img-fluid mt-3 d-none" style="max-height:200px;">
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control" required>
                        </div>
                        <div class="col">
                            <label>Jenis Surat</label>
                            <select name="jenis_surat" class="form-control" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="SPPHB">SPPHB (Surat Permintaan Penawaran Harga Barang)</option>
                                <option value="SPH">SPH (Surat Penawaran Harga)</option>
                            </select>
                        </div>
                    </div>

                    <label class="mt-2">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>

                    <div class="progress mt-3 d-none" id="progressContainer">
                        <div class="progress-bar" id="progressBar" style="width:0%">0%</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal" onclick="$('#uploadModal').modal('hide')">Batal</button>
                    <button class="btn btn-dark" type="submit">Upload</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // === DataTables ===
    $('#rekananTable').DataTable({
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

    // === AJAX Upload ===
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    window.openUploadModal = function(vendorID) {
        $('#vendor_id').val(vendorID);
        $('#uploadForm')[0].reset();
        $('#fileName').text('');
        $('#imgPreview').addClass('d-none').attr('src','');
        $('#progressContainer').addClass('d-none');
        $('#progressBar').css('width','0%').text('0%');
        $('#uploadModal').modal('show');
    };

    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    const imgPreview = document.getElementById('imgPreview');

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background = "#eef7ee"; });
    dropZone.addEventListener('dragleave', e => { e.preventDefault(); dropZone.style.background = "white"; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.background = "white";
        if (!e.dataTransfer?.files.length) return;
        const file = e.dataTransfer.files[0];
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        fileName.innerHTML = "";
        imgPreview.classList.add('d-none');
        if (!file) return;

        const allowed = ['application/pdf', 'image/png', 'image/jpeg'];
        if (!allowed.includes(file.type)) {
            Swal.fire({ icon: 'error', title: 'Format Salah', text: 'Gunakan format PDF, JPG, atau PNG' });
            fileInput.value = "";
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB' });
            fileInput.value = "";
            return;
        }

        fileName.innerHTML = "✅ " + file.name;
        if (file.type.startsWith('image')) {
            const reader = new FileReader();
            reader.onload = e => {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $('#progressContainer').removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.vendor.uploadSurat') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", evt => {
                    if (evt.lengthComputable) {
                        let percent = Math.round((evt.loaded / evt.total) * 100);
                        $('#progressBar').css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            success: function() {
                $('#uploadModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Dokumen berhasil diunggah.',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => location.reload(), 2000);
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan saat mengunggah dokumen.' });
                $('#progressContainer').addClass('d-none');
            }
        });
    });
});
</script>
@endpush

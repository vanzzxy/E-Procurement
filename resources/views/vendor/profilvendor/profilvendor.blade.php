@extends('vendor.layout.sidebarvendor')

@section('title', 'Profil Vendor')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>

/* ============================
   GLOBAL CONTAINER
=============================== */
.container {
    max-width: 95% !important;
}

/* ============================
   PROFILE CARD
=============================== */
.profile-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

/* FOTO – smooth hover */
.profile-img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e2e8f0;
    transition: transform .25s ease, box-shadow .25s ease;
}

.profile-img:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 18px rgba(0,0,0,0.18);
}

/* Upload wrapper */
.upload-wrapper {
    margin-top: 15px;
    padding-top: 12px;
    border-top: 1px solid #e2e8f0;
    animation: fadeIn .35s ease-out;
}

/* Tombol upload */
.custom-file-upload {
    margin-top: 10px;
    padding: 7px;
    background: #f8f9fa;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 7px;
    display: inline-block;
    transition: all .3s ease;
}

.custom-file-upload:hover {
    background: #e8f3ff;
    border-color: #4e9ef7;
}

/* Smooth fade */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ============================
   PROFILE DETAILS CARD
=============================== */
.profile-details {
    border-radius: 14px;
    padding: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.card-label {
    font-weight: 600;
    color: #4a5568;
}

.edit-highlight {
    border: 1px solid #4e9ef7 !important;
    box-shadow: 0 0 6px rgba(78,158,247,0.5);
}

/* ============================
   DOKUMEN VENDOR CARD
=============================== */
.vendor-doc-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.vendor-doc-section {
    padding: 15px 0;
}

.vendor-doc-section:not(:last-child) {
    border-bottom: 1px solid #e2e8f0;
}

/* ============================
   MODAL UPLOAD FOTO + CROPPER
=============================== */
#dropArea {
    min-height: 200px !important;
    padding: 40px !important;
}

#dropArea:hover {
    border-color: #007bff !important;
    background: #f0f8ff;
}

#uploadPreview {
    max-width: 100%;
    max-height: 250px !important;
    object-fit: contain;
    display: none;
    margin-top: 20px;
    border-radius: 10px;
}

#uploadFotoModal .modal-body {
    max-height: 700px !important;
    overflow-y: auto;
}

#cropModal .modal-dialog {
    max-width: 900px !important;
    margin: 1.5rem auto;
}

#cropModal .modal-body {
    height: 65vh !important;
    padding: 0;
    display: flex;
    flex-direction: column;
}

.crop-toolbar {
    padding: .75rem 1rem;
    display: flex;
    gap: .5rem;
    align-items: center;
    background: #f8f9fa;
}

.crop-area {
    flex: 1;
    background: #e9ecef;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

#image-preview {
    max-width: 100%;
    max-height: 100%;
}

.aspect-btn.active {
    border-width: 2px;
}

.btn-small {
    padding: .35rem .6rem;
    font-size: .875rem;
}

</style>

@endpush


@section('content')
<div class="main-content container">
    <h1 class="mt-4 font-weight-bold">PROFIL VENDOR</h1>

    <div class="row mt-4">

        <!-- LEFT -->
        <div class="col-md-4">
            <div class="profile-card shadow">

<!-- FOTO -->
<img src="{{ asset($vendor->user->photo ?? 'img/vendor-default.png') }}"
     id="previewImage"
     class="profile-img">

<!-- WRAPPER SMOOTH -->
<div class="upload-wrapper text-center">
    <button type="button" id="openUploadModal" class="custom-file-upload">
        <i class="fas fa-upload"></i> Upload Foto
    </button>
</div>

<input type="file" id="fotoInput" accept="image/*" class="d-none">


                <input type="file" id="fotoInput" accept="image/*" class="d-none">

                <h3 class="mt-3">{{ $vendor->nama_perusahaan }}</h3>
                <p class="text-muted">{{ $vendor->email_perusahaan }}</p>

                <button id="btnEdit" type="button" class="btn btn-primary btn-block mt-3">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>

                <button id="btnSave" type="button" class="btn btn-success btn-block mt-2 d-none">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

            </div>

            {{-- Dokumen Vendor --}}
<div class="mt-4">
    <div class="vendor-doc-card">

        <h3 class="mb-4">Dokumen Vendor</h3>

                    {{-- NPWP --}}
<div class="vendor-doc-section">
                        <h5 class="mb-2">NPWP</h5>

                        @if($vendor->file_npwp)
                            <p class="text-success">Dokumen sudah diunggah</p>

                            <a href="{{ route('vendor.downloadDokumen', 'npwp') }}"
                               class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download NPWP
                            </a>
                            <form class="form-delete-dokumen"
                                  action="{{ route('vendor.deleteDokumen', 'npwp') }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <form class="form-upload-dokumen"
                                  action="{{ route('vendor.uploadDokumen') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="field" value="file_npwp">
                                <input type="file" name="document" class="form-control mt-2" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-upload"></i> Unggah NPWP
                                </button>
                            </form>
                        @endif
                    </div>

                    <hr>

                    {{-- ISO --}}
<div class="vendor-doc-section">
                        <h5 class="mb-2">ISO</h5>
                        @if($vendor->file_iso)
                            <p class="text-success">Dokumen sudah diunggah</p>
                            <a href="{{ route('vendor.downloadDokumen', 'iso') }}"
                               class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download ISO
                            </a>
                            <form class="form-delete-dokumen"
                                  action="{{ route('vendor.deleteDokumen', 'iso') }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <form class="form-upload-dokumen"
                                  action="{{ route('vendor.uploadDokumen') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="field" value="file_iso">
                                <input type="file" name="document" class="form-control mt-2" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-upload"></i> Unggah ISO
                                </button>
                            </form>
                        @endif
                    </div>

                    <hr>

                    {{-- SIUP --}}
<div class="vendor-doc-section">
                        <h5 class="mb-2">SIUP</h5>
                        @if($vendor->file_siup)
                            <p class="text-success">Dokumen sudah diunggah</p>
                            <a href="{{ route('vendor.downloadDokumen', 'siup') }}"
                               class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download SIUP
                            </a>
                            <form class="form-delete-dokumen"
                                  action="{{ route('vendor.deleteDokumen', 'siup') }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <form class="form-upload-dokumen"
                                  action="{{ route('vendor.uploadDokumen') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="field" value="file_siup">
                                <input type="file" name="document" class="form-control mt-2" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-upload"></i> Unggah SIUP
                                </button>
                            </form>
                        @endif
                    </div>

                    <hr>

                    {{-- SKF --}}
<div class="vendor-doc-section">
                        <h5 class="mb-2">SKF</h5>
                        @if($vendor->file_skf)
                            <p class="text-success">Dokumen sudah diunggah</p>
                            <a href="{{ route('vendor.downloadDokumen', 'skf') }}"
                               class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download SKF
                            </a>
                            <form class="form-delete-dokumen"
                                  action="{{ route('vendor.deleteDokumen', 'skf') }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <form class="form-upload-dokumen"
                                  action="{{ route('vendor.uploadDokumen') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="field" value="file_skf">
                                <input type="file" name="document" class="form-control mt-2" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-upload"></i> Unggah SKF
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-8">

            <form id="vendorEditForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="kategori_perusahaan_hidden" name="kategori_hidden">

                <div class="profile-details">

                    <h4 class="mb-4 font-weight-bold">Profil Perusahaan</h4>

                    @php
                        $fields = [
                            'jenis_badan_usaha'=>'Jenis Badan Usaha',
                            'nama_perusahaan'=>'Nama Perusahaan',
                            'asal_perusahaan'=>'Asal Perusahaan',
                            'npwp'=>'NPWP',
                            'fax'=>'Fax',
                            'telepon_perusahaan'=>'Telepon',
                            'email_perusahaan'=>'Email'
                        ];
                    @endphp

                    @foreach ($fields as $field => $label)
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label card-label">{{ $label }}</label>
                        <div class="col-sm-8">

                            @if($field == 'jenis_badan_usaha')
                                <select class="form-control editable select2-tags" name="jenis_badan_usaha" disabled>
                                    @php $options = ['PT','CV','UD','Lainnya']; @endphp
                                    @foreach($options as $opt)
                                        <option value="{{ $opt }}" @selected($vendor->jenis_badan_usaha == $opt)>{{ $opt }}</option>
                                    @endforeach
                                </select>

                            @elseif($field == 'asal_perusahaan')
                                <select class="form-control editable select2-tags" name="asal_perusahaan" disabled>
                                    @php $options = ['Lokal','Internasional','Lainnya']; @endphp
                                    @foreach($options as $opt)
                                        <option value="{{ $opt }}" @selected($vendor->asal_perusahaan == $opt)>{{ $opt }}</option>
                                    @endforeach
                                </select>

                            @else
                                <input class="form-control editable"
                                       name="{{ $field }}"
                                       value="{{ $vendor->$field }}"
                                       readonly>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Kategori -->
                    <div class="form-group row mt-3">
                        <label class="col-sm-4 col-form-label card-label">Kategori</label>
                        <div class="col-sm-8">

                            <select class="form-control kategori-select editable"
                                    name="kategori_perusahaan[]" multiple>

                                @php
                                    $selected = json_decode($vendor->kategori_perusahaan, true);
                                    if (!is_array($selected)) $selected = [];
                                @endphp

                                @foreach($masterCategories as $cat)
                                    <option value="{{ $cat->nama_master }}"
                                        @selected(in_array($cat->nama_master, $selected))>
                                        {{ $cat->nama_master }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group row mt-3 mb-4">
                        <label class="col-sm-4 col-form-label card-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea class="form-control editable"
                                      name="alamat_perusahaan"
                                      readonly>{{ $vendor->alamat_perusahaan }}</textarea>
                        </div>
                    </div>

                    <hr>
                    <h4 class="mt-4 font-weight-bold">Kontak Pribadi 1</h4>

                    @php
                        $c1 = ['nama_lengkap1'=>'Nama','jabatan1'=>'Jabatan','email1'=>'Email','telepon1'=>'Telepon'];
                    @endphp

                    @foreach ($c1 as $field => $label)
                    <div class="form-group row mt-3">
                        <label class="col-sm-4 col-form-label card-label">{{ $label }}</label>
                        <div class="col-sm-8">
                            <input class="form-control editable"
                                   name="{{ $field }}"
                                   value="{{ $vendor->$field }}"
                                   readonly>
                        </div>
                    </div>
                    @endforeach

                    <hr>
                    <h4 class="mt-4 font-weight-bold">Kontak Pribadi 2</h4>

                    @php
                        $c2 = ['nama_lengkap2'=>'Nama','jabatan2'=>'Jabatan','email2'=>'Email','telepon2'=>'Telepon'];
                    @endphp

                    @foreach ($c2 as $field => $label)
                    <div class="form-group row mt-3">
                        <label class="col-sm-4 col-form-label card-label">{{ $label }}</label>
                        <div class="col-sm-8">
                            <input class="form-control editable"
                                   name="{{ $field }}"
                                   value="{{ $vendor->$field }}"
                                   readonly>
                        </div>
                    </div>
                    @endforeach

                </div>
            </form>

        </div>

    </div>
</div>


{{-- Modal Upload Foto --}}
<div class="modal fade" id="uploadFotoModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Upload Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <div id="dropArea"
                     style="
                        border: 3px dashed #6c757d;
                        padding: 60px;
                        border-radius: 12px;
                        cursor: pointer;
                        transition: .3s;
                        width: 100%;
                        min-height: 280px;
                     ">
                    <h5 class="text-muted mb-3">Drag & Drop Foto di sini</h5>
                    <p class="text-muted">atau klik untuk memilih file</p>
                </div>

                <img id="uploadPreview" style="max-width: 100%; display:none; margin-top:25px; border-radius:10px;">

            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <button id="btnToCrop" class="btn btn-primary d-none">
                    Lanjutkan Crop
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Modal Crop --}}
<div class="modal fade" id="cropModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Crop Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="crop-toolbar">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn active" data-ratio="1">1 : 1</button>
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn" data-ratio="0.8">4 : 5</button>
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn" data-ratio="1.333333">3 : 4</button>
                    </div>

                    <div class="ms-3 d-flex align-items-center" style="gap:.35rem;">
                        <button id="zoomIn" class="btn btn-secondary btn-small"><i class="fas fa-search-plus"></i></button>
                        <button id="zoomOut" class="btn btn-secondary btn-small"><i class="fas fa-search-minus"></i></button>
                        <button id="rotateLeft" class="btn btn-secondary btn-small"><i class="fas fa-undo"></i></button>
                        <button id="rotateRight" class="btn btn-secondary btn-small"><i class="fas fa-redo"></i></button>
                    </div>

                    <div class="ms-auto text-muted small">Atur area crop lalu simpan.</div>
                </div>

                <div class="crop-area">
                    <img id="image-preview">
                </div>
            </div>

            <div class="modal-footer">
                <button id="cropButton" class="btn btn-primary">Crop & Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
$(document).ready(function(){

    // ======================
    //    UPLOAD DOKUMEN
    // ======================
    $(document).on("submit", ".form-upload-dokumen", function(e){
        e.preventDefault();   // HENTIKAN submit bawaan browser
        e.stopImmediatePropagation(); // HENTIKAN event dobel

        let form = this;
        let formData = new FormData(form);

        Swal.fire({
            title: "Mengunggah Dokumen...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        $.ajax({
            url: $(form).attr("action"),
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Dokumen berhasil diunggah"
                });

                // 🔥 UPDATE UI TANPA RELOAD
                let parent = $(form).parent();
                parent.html(`
                    <p class="text-success">Dokumen sudah diunggah</p>
                    <a href="${res.download_url}" class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i> Download
                    </a>

                    <form class="form-delete-dokumen" action="${res.delete_url}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm mt-2">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                `);
            },

            error: function(xhr){
                let msg = xhr.responseJSON?.message ?? "Gagal mengunggah dokumen.";
                Swal.fire({ icon: "error", title: "Gagal", text: msg });
            }
        });
    });



    // ======================
    //       DELETE DOKUMEN
    // ======================
    $(document).on("submit", ".form-delete-dokumen", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        let form = this;

        Swal.fire({
            title: "Hapus Dokumen?",
            text: "Dokumen akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then(result => {

            if (!result.isConfirmed) return;

            $.ajax({
                url: $(form).attr("action"),
                method: "POST",
                data: $(form).serialize(),
                success: function(res){

                    Swal.fire({
                        icon: "success",
                        title: "Dihapus",
                        text: "Dokumen berhasil dihapus"
                    });

                    // 🔥 UPDATE UI TANPA RELOAD
                    let parent = $(form).parent();
                    parent.html(`
                        <form class="form-upload-dokumen" 
                              action="${res.upload_url}" 
                              method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="field" value="${res.field}">
                            <input type="file" name="document" class="form-control mt-2" required>

                            <button type="submit" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-upload"></i> Unggah ${res.label}
                            </button>
                        </form>
                    `);
                },

                error: function(){
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Tidak dapat menghapus dokumen"
                    });
                }
            });

        });
    });

});
</script>


{{-- FOTO CROPPER --}}
<script>
$(document).ready(function () {
    let cropper = null;
    let selectedFile = null;
    let currentRatio = 1;

    $("#openUploadModal").click(function () {
        $("#uploadPreview").hide();
        $("#btnToCrop").addClass("d-none");
        new bootstrap.Modal(document.getElementById("uploadFotoModal")).show();
    });

    $("#fotoInput").change(function (e) {
        selectedFile = e.target.files[0];
        if (selectedFile) showPreview(selectedFile);
    });

    const dropArea = document.getElementById("dropArea");

    dropArea.addEventListener("click", function () {
        $("#fotoInput").click();
    });

    dropArea.addEventListener("dragover", function (e) {
        e.preventDefault();
        dropArea.style.borderColor = "#007bff";
    });

    dropArea.addEventListener("dragleave", function () {
        dropArea.style.borderColor = "#6c757d";
    });

    dropArea.addEventListener("drop", function (e) {
        e.preventDefault();
        dropArea.style.borderColor = "#6c757d";
        selectedFile = e.dataTransfer.files[0];
        if (selectedFile) showPreview(selectedFile);
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            $("#uploadPreview").attr("src", ev.target.result).show();
            $("#btnToCrop").removeClass("d-none");
        };
        reader.readAsDataURL(file);
    }

    $("#btnToCrop").click(function () {
        const file = selectedFile;
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (ev) {
            $("#image-preview").attr("src", ev.target.result);

            bootstrap.Modal.getInstance(document.getElementById("uploadFotoModal")).hide();
            new bootstrap.Modal(document.getElementById("cropModal")).show();
        };
        reader.readAsDataURL(file);
    });

    $("#cropModal").on("shown.bs.modal", function () {
        const img = document.getElementById("image-preview");

        if (cropper) cropper.destroy();

        cropper = new Cropper(img, {
            viewMode: 1,
            autoCropArea: 1,
            background: false,
            aspectRatio: currentRatio
        });
    });

    $(".aspect-btn").click(function () {
        currentRatio = parseFloat($(this).data("ratio"));
        cropper?.setAspectRatio(currentRatio);
        $(".aspect-btn").removeClass("active");
        $(this).addClass("active");
    });

    $("#cropButton").click(function () {
        if (!cropper) return;

        cropper.getCroppedCanvas({ width: 800, height: 800 }).toBlob((blob) => {

            const newFile = new File([blob], "photo_" + Date.now() + ".png", {
                type: "image/png"
            });

            const dt = new DataTransfer();
            dt.items.add(newFile);
            document.getElementById("fotoInput").files = dt.files;

            $("#previewImage").attr("src", URL.createObjectURL(newFile));

            bootstrap.Modal.getInstance(document.getElementById("cropModal")).hide();

            let formData = new FormData();
            formData.append("foto", newFile);
            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('vendor.updatePhoto', $vendor->id_vendor) }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function (res) {
                    $("#previewImage").attr("src", res.url);
                    $("#uploadPreview").attr("src", res.url);

                    Swal.fire("Berhasil", "Foto berhasil diperbarui & disimpan", "success");
                },

                error: function () {
                    Swal.fire("Error", "Gagal menyimpan foto", "error");
                }
            });

        }, "image/png", 0.92);
    });
});
</script>

{{-- EDIT PROFIL --}}
<script>
$(function(){

    $('.kategori-select').select2({ width:'100%' });

    $('.select2-tags').select2({
        width: '100%',
        tags: true,
        dropdownAutoWidth: true,
        placeholder: 'Pilih atau ketik',
        allowClear: true
    });

    let editing = false;

    function toggleEdit(enabled) {

        $(".editable").each(function () {

            if ($(this).is("select")) {

                $(this).prop("disabled", !enabled);
                $(this).trigger("change.select2");

            } else {
                $(this).prop("readonly", !enabled);
            }

            if (enabled) {
                $(this).addClass("edit-highlight");
            } else {
                $(this).removeClass("edit-highlight");
            }
        });

        if (enabled) {
            $("#btnSave").removeClass("d-none");
            $("#btnEdit").text("Batal").removeClass("btn-primary").addClass("btn-warning");
        } else {
            $("#btnSave").addClass("d-none");
            $("#btnEdit").text("Edit Profil").removeClass("btn-warning").addClass("btn-primary");
        }
    }

    toggleEdit(false);

    $("#btnEdit").click(() => {
        editing = !editing;
        toggleEdit(editing);
    });

    $("#btnSave").click(function(e){
        e.preventDefault();

        let kategoriArr = $(".kategori-select").val() || [];
        $("#kategori_perusahaan_hidden").val(JSON.stringify(kategoriArr));

        let formData = new FormData($("#vendorEditForm")[0]);

        $.ajax({
            url: "{{ route('vendor.updateProfile',$vendor->id_vendor) }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){

                editing = false;
                toggleEdit(false);

                $(".profile-card h3").text($("#vendorEditForm [name='nama_perusahaan']").val());
                $(".profile-card p.text-muted").text($("#vendorEditForm [name='email_perusahaan']").val());

                Swal.fire("Berhasil","Profil berhasil diperbarui","success");
            },
            error: function(){
                Swal.fire("Error","Gagal memperbarui profil","error");
            }
        });
    });

});
</script>

@endpush

@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/detailinboxadmin.css') }}">
<style>
.main-content {
    background: #ffffff;
    border-radius: 12px;
    padding: 40px 50px;
    margin: 30px auto;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    width: 95%;
    max-width: 1100px;
}

.main-content h1 {
    font-weight: 700;
    font-size: 26px;
    color: #2c3e50;
    text-align: left;
    margin-bottom: 10px;
}

.underline {
    width: 80px;
    height: 4px;
    background: #1e88e5;
    border-radius: 2px;
    margin-bottom: 25px;
}

.card {
    display: flex;
    align-items: flex-start;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
}

.card:hover { transform: translateY(-2px); }

.card-icon {
    flex-shrink: 0;
    width: 65px;
    height: 65px;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-right: 20px;
}

.card-content { flex: 1; }

.card-content h4 {
    color: #1e88e5;
    font-weight: 600;
    margin-bottom: 8px;
}

.card-content p {
    color: #555;
    line-height: 1.6;
    margin-bottom: 10px;
}

.card-actions { text-align: right; margin-top: 20px; }

.card-actions .btn.primary {
    background: #1e88e5;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.card-actions .btn.primary:hover { background: #1565c0; }

.btn-back {
    background: #6c757d;
    color: white;
    border-radius: 8px;
    padding: 8px 16px;
    text-decoration: none;
}
.btn-back:hover { background: #5a6268; }

/* Modal fix */
.modal { z-index: 2000 !important; }
.modal-backdrop { z-index: 1999 !important; }

.modal.fade .modal-dialog {
    transform: none !important;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%, -50%) !important;
}

.modal-dialog.modal-lg { max-width: 950px !important; }

.swal2-container { z-index: 3000 !important; }
</style>
@endpush

@section('tittle', "Detail Inbox")

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>DETAIL SURAT MASUK</h1>
        <a href="{{ route('admin.inbox') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="underline"></div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-folder"></i>
        </div>

        <div class="card-content">
            <h4>{{ $surat->jenis_surat }}</h4>
            <p>
                <strong>Pengirim:</strong>
                {{ $surat->vendor->nama_perusahaan ?? 'Tidak diketahui' }} <br>
                <strong>Nomor Surat:</strong> {{ $surat->id_suratadmin }} <br>
                <strong>File Surat:</strong>
                <a href="{{ route('admin.inbox.download', $surat->id_suratadmin) }}" class="text-primary">
                    Download Dokumen
                </a>
            </p>

            <h4>Deskripsi :</h4>
            <p>{{ $surat->deskripsi }}</p>
        </div>

        <div class="card-actions w-100 d-flex justify-content-end">
            <a href="javascript:void(0)" class="btn primary" onclick="openReplyModal({{ $surat->id_suratadmin }})">
                <i class="fas fa-reply"></i> Balas Vendor
            </a>
        </div>
    </div>
</div>

<!-- ========= MODAL BALAS ========= -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-0">
                <h4 class="m-0 font-weight-bold">Kirim Balasan ke Vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:26px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="replyForm" method="POST" enctype="multipart/form-data" class="px-4 pb-4">
                @csrf
                <input type="hidden" name="id_surat" id="id_surat">
                <input type="hidden" name="id_vendor" value="{{ $surat->id_vendor }}">

                <div class="modal-body">
                    <!-- AREA DRAG & DROP -->
                    <div id="replyDropZone"
                        style="border:2px dashed #8faadd; border-radius:10px; text-align:center; padding:30px; cursor:pointer;">
                        <i class="fa fa-upload" style="font-size:40px;"></i>
                        <p class="mt-2">Seret dan letakkan file di sini<br>atau</p>

                        <button type="button" class="btn btn-primary"
                            onclick="document.getElementById('replyFile').click()">
                            Jelajahi File
                        </button>

                        <input type="file" name="file" id="replyFile" hidden>
                        <p id="replyFileName" class="mt-3 font-weight-bold text-primary"></p>
                        <img id="replyPreview" src="" class="img-fluid mt-3 d-none" style="max-height:200px;">
                    </div>

                    <!-- ROW 2 KOLOM -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Jenis Surat</label>
                            <select name="jenis_surat" class="form-control" required>
                                <option value="NEGOSIASI">Negosiasi</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="font-weight-bold">Deskripsi</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Masukkan Deskripsi" required></textarea>
                        </div>
                    </div>

                    <div class="progress mt-3 d-none" id="replyProgressContainer">
                        <div class="progress-bar" id="replyProgressBar" style="width:0%">0%</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius:8px;">Batal</button>
                    <button type="submit" class="btn btn-dark" style="border-radius:8px;">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

        // Tombol X dan Batal agar bisa menutup modal
    $(document).on('click', '[data-dismiss="modal"], .close', function () {
        $('#replyModal').modal('hide');
    });


    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    window.openReplyModal = function(id){
        $('#id_surat').val(id);
        $('#replyForm')[0].reset();
        $('#replyFileName').text('');
        $('#replyPreview').addClass('d-none').attr('src','');
        $('#replyProgressContainer').addClass('d-none');
        $('#replyProgressBar').css('width','0%').text('0%');
        $('#replyModal').modal('show');
    };

    const dropZone = document.getElementById('replyDropZone');
    const fileInput = document.getElementById('replyFile');
    const fileName = document.getElementById('replyFileName');
    const imgPreview = document.getElementById('replyPreview');

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background = "#eef7ee"; });
    dropZone.addEventListener('dragleave', e => { e.preventDefault(); dropZone.style.background = "white"; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault(); dropZone.style.background = "white";
        if(!e.dataTransfer.files.length) return;
        const dt = new DataTransfer();
        dt.items.add(e.dataTransfer.files[0]);
        fileInput.files = dt.files;
        fileInput.dispatchEvent(new Event('change'));
    });

    fileInput.addEventListener('change', () => {
        let file = fileInput.files[0];
        fileName.innerHTML = "";
        imgPreview.classList.add('d-none');

        if(!file) return;
        let allowed = ["application/pdf","image/png","image/jpeg"];
        if(!allowed.includes(file.type)){
            alert("Format harus PDF, JPG, atau PNG");
            fileInput.value = "";
            return;
        }

        if(file.size > 2*1024*1024){
            alert("Ukuran maksimal 2MB");
            fileInput.value = "";
            return;
        }

        fileName.innerHTML = "✅ " + file.name;
        if(file.type.startsWith('image')){
            let reader = new FileReader();
            reader.onload = e => { imgPreview.src = e.target.result; imgPreview.classList.remove('d-none'); };
            reader.readAsDataURL(file);
        }
    });

    $('#replyForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $('#replyProgressContainer').removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.inbox.balas.ajax') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,

            xhr: function(){
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", evt => {
                    if(evt.lengthComputable){
                        let percent = Math.round((evt.loaded / evt.total) * 100);
                        $('#replyProgressBar').css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },

            success: function(){
                $('#replyModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Balasan berhasil dikirim.',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    position: 'center'
                });
                setTimeout(() => location.reload(), 2000);
            },

            error: function(xhr){
                console.log(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan: ' + xhr.statusText,
                });
            }
        });
    });
});
</script>
@endpush

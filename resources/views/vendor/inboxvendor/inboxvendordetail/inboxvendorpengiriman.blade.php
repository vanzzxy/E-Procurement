@extends('vendor.layout.sidebarvendor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vendor/penawarandetail.css') }}">
<style>
/* SweetAlert2 selalu di depan */
.swal2-container {
    z-index: 20000 !important;
}
.swal2-popup {
    z-index: 20001 !important;
}

/* Modal Bootstrap tetap di bawah SweetAlert2 */
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
</style>
@endpush

@section('tittle', "Penawaran Detail")

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">
    <h1>DETAIL INBOX</h1>
    <div class="underline"></div>

    <div class="card">
        <div class="card-icon"><i class="fas fa-folder"></i></div>
        <div class="card-content">
            <h4>{{ $surat->jenis_surat }}</h4>
            <p>
                Pengirim :
                @if(isset($surat->user->id_user))
                    ADMIN ({{ $surat->user->id_user }}) PT. XYZ
                @else
                    ADMIN PT. XYZ
                @endif
                <br>
                Nomor Surat : {{ $surat->nomor_surat }} <br>
                File Surat :
                <a href="{{ route('vendor.inbox.download', $surat->id_surat) }}">Download Dokumen</a>
            </p>
            <h4>Deskripsi :</h4>
            <p>{{ $surat->deskripsi }}</p>
        </div>
        <div class="card-actions">
            <a href="javascript:void(0)" class="btn primary" onclick="openReplyModal({{ $surat->id_surat }})">
                <i class="fas fa-reply"></i> Balas
            </a>
        </div>
    </div>
</div>

<!-- MODAL BALAS -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-0">
                <h4 class="m-0 font-weight-bold">Unggah Dokumen</h4>
                <button type="button" class="close" data-dismiss="modal" style="font-size:26px;">&times;</button>
            </div>
            <form id="replyForm" method="POST" enctype="multipart/form-data" class="px-4 pb-4">
                @csrf
                <input type="hidden" name="id_surat" id="id_surat">
                <div class="modal-body">
                    <!-- AREA DRAG & DROP -->
                    <div id="replyDropZone" style="border:2px dashed #8faadd; border-radius:10px; text-align:center; padding:30px; cursor:pointer;">
                        <i class="fa fa-upload" style="font-size:40px;"></i>
                        <p class="mt-2">Seret dan letakkan file di sini<br>atau</p>
                        <button type="button" class="btn btn-primary" id="browseBtn">
                            Jelajahi File
                        </button>
                        <input type="file" name="file" id="replyFile" hidden>
                        <p id="replyFileName" class="mt-3 font-weight-bold text-primary"></p>
                        <img id="replyPreview" src="" class="img-fluid mt-3 d-none" style="max-height:200px;">
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Jenis Surat</label>
                            <select name="jenis_surat" class="form-control" required>
                                <option value="SPB">SPB (Surat Perintah Bayar)</option>
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
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    window.openReplyModal = function(id){
        $('#id_surat').val(id);
        $('#replyForm')[0].reset();
        $('#replyFileName').text('');
        $('#replyPreview').addClass('d-none').attr('src','');
        $('#replyProgressContainer').addClass('d-none');
        $('#replyProgressBar').css('width','0%').text('0%');
        $('#replyModal').modal('show');
    };

    // drag & drop + input file
    const dropZone = document.getElementById('replyDropZone');
    const fileInput = document.getElementById('replyFile');
    const fileName = document.getElementById('replyFileName');
    const imgPreview = document.getElementById('replyPreview');
    const browseBtn = $('#browseBtn');

    dropZone.addEventListener('click', () => fileInput.click());
    browseBtn.click(function(){ fileInput.click(); });

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
        if(!allowed.includes(file.type)){ alert("Format harus PDF, JPG, PNG"); fileInput.value=""; return; }
        if(file.size > 2*1024*1024){ alert("Maksimal 2MB"); fileInput.value=""; return; }
        fileName.innerHTML = "✅ " + file.name;
        if(file.type.startsWith('image')){
            let reader = new FileReader();
            reader.onload = e => { imgPreview.src = e.target.result; imgPreview.classList.remove('d-none'); };
            reader.readAsDataURL(file);
        }
    });

    // AJAX submit
    $('#replyForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $('#replyProgressContainer').removeClass('d-none');
        $('#replyProgressBar').css('width','0%').text('0%');

        $.ajax({
            url: "{{ route('vendor.penawaran.balas.ajax') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if(evt.lengthComputable){
                        let percent = Math.round((evt.loaded / evt.total) * 100);
                        $('#replyProgressBar').css('width', percent + '%').text(percent + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(res){
                $('#replyModal').modal('hide');
                setTimeout(function(){
                    Swal.fire({
                        icon: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU' ? 'info' : 'success',
                        title: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU' ? 'Tidak Setuju' : 'Berhasil!',
                        text: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU' ? 'Anda dapat mengajukan surat penawaran lainnya, terima kasih.' : 'Surat berhasil dikirim.',
                        showConfirmButton: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU',
                        timer: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU' ? undefined : 2000,
                        timerProgressBar: res.jenis_surat.toUpperCase() === 'TIDAK SETUJU' ? false : true,
                        position: 'center',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
                }, 200);
                if(res.jenis_surat.toUpperCase() !== 'TIDAK SETUJU'){
                    setTimeout(()=>location.reload(),2000);
                }
            },
            error: function(xhr){
                let msg = "Gagal mengirim balasan.";
                if(xhr.status === 422){ msg = xhr.responseJSON.message || msg; }
                Swal.fire({ icon:'error', title:'Gagal!', text: msg });
                console.log(xhr.responseText);
            }
        });
    });
});
</script>
@endpush

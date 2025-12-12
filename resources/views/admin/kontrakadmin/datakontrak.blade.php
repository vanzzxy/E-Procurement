@extends('admin.layout.sidebaradmin')

@section('tittle', "Data Kontrak Upload || PT.INKA Multi Solusi E-Procurement")

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-3">Daftar Kontrak yang Sudah Di-upload</h4>

    @if($kontraks->isEmpty())
        <p class="text-center">Belum ada kontrak yang di-upload.</p>
    @else
        <table class="table table-hover table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No. PO</th>
                    <th>Nama Perusahaan</th>
                    <th>Kategori Barang</th>
                    <th>Harga Total</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kontraks as $kontrak)
                <tr id="row-{{ $kontrak->id }}">
                    <td>{{ $kontrak->no_purchaseorder }}</td>
                    <td>{{ $kontrak->vendor }}</td>
                    <td>{{ $kontrak->kategori_barang }}</td>
                    <td>{{ $kontrak->harga_total ? 'Rp '.number_format($kontrak->harga_total,0,',','.') : '-' }}</td>
<td>
    {{
        $kontrak->kontrak && $kontrak->kontrak->deadline
        ? \Carbon\Carbon::parse($kontrak->kontrak->deadline)->format('d-m-Y')
        : '-'
    }}
</td>
<td>
    @include('admin.layout.status_badge', [
        'status' => $kontrak->status,
        'id' => $kontrak->id
    ])
</td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning btn-edit-status"
                            data-bs-toggle="modal"
                            data-bs-target="#editStatusModal"
                            data-id="{{ $kontrak->id }}"
                            data-status="{{ $kontrak->status }}">
                            <i class="fas fa-edit"></i> Edit Status
                        </button>

                        <button type="button" class="btn btn-sm btn-danger btn-delete-upload" data-id="{{ $kontrak->id }}">
                            <i class="fas fa-trash"></i> Hapus Upload
                        </button>

                        <button type="button" class="btn btn-sm btn-primary btn-kirim"
                            data-bs-toggle="modal"
                            data-bs-target="#kirimModal"
                            data-id="{{ $kontrak->id }}"
                            data-no="{{ $kontrak->no_purchaseorder }}"
                            data-perusahaan="{{ $kontrak->vendor }}"
                            data-kategori="{{ $kontrak->kategori_barang }}"
                            data-harga="{{ $kontrak->harga_total ? 'Rp '.number_format($kontrak->harga_total,0,',','.') : '-' }}">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Modal Kirim Dokumen --}}
<div class="modal fade" id="kirimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
<form id="formKirim" action="{{ route('datakontrak.kirim') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="kontrak_id" id="kontrak_id">

                <div class="modal-header">
                    <h5 class="modal-title">Kirim Dokumen Kontrak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label>No. PO</label>
                            <input type="text" id="modalNoPO" class="form-control" readonly>
                        </div>
                        <div class="col">
                            <label>Nama Perusahaan</label>
                            <input type="text" id="modalPerusahaan" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Kategori Barang</label>
                            <input type="text" id="modalKategori" class="form-control" readonly>
                        </div>
                        <div class="col">
                            <label>Harga Total</label>
                            <input type="text" id="modalHarga" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Surat</label>
                        <input type="text" name="jenis_surat" class="form-control" value="Kontrak" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi..."></textarea>
                    </div>

                    <!-- Drag & Drop Upload -->
                    <div id="dropZone" class="border border-secondary rounded text-center p-4 mb-3" style="cursor:pointer;">
                        <i class="fa fa-upload text-primary" style="font-size:30px;"></i>
                        <p class="m-0">Seret & letakkan file di sini atau klik untuk memilih file (pdf, doc, docx, jpg, jpeg, png)</p>
                        <input type="file" name="dokumen" id="fileInput" hidden>
                        <p id="fileName" class="mt-2 fw-bold text-success"></p>
                        <img id="imgPreview" src="" class="img-fluid mt-3 d-none" style="max-height:200px;">
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress mt-2 d-none" id="progressContainer">
                        <div class="progress-bar" id="progressBar" style="width:0%">0%</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Status --}}
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditStatus">
                @csrf
                @method('PUT')
                <input type="hidden" name="kontrak_id" id="edit_kontrak_id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Status Kontrak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-control">
                            <option value="menunggu">Menunggu</option>
                            <option value="setuju">Setuju</option>
                            <option value="pengiriman">Pengiriman</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    const imgPreview = document.getElementById('imgPreview');

    // Populate Kirim Modal
    $('#kirimModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        $('#kontrak_id').val(button.data('id'));
        $('#modalNoPO').val(button.data('no'));
        $('#modalPerusahaan').val(button.data('perusahaan'));
        $('#modalKategori').val(button.data('kategori'));
        $('#modalHarga').val(button.data('harga'));

        fileInput.value = '';
        fileName.textContent = '';
        imgPreview.src = '';
        imgPreview.classList.add('d-none');
        $('#progressContainer').addClass('d-none');
        $('#progressBar').css('width','0%').text('0%');
    });

    // Drag & Drop Upload
    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background = "#eef7ee"; });
    dropZone.addEventListener('dragleave', e => { e.preventDefault(); dropZone.style.background = "white"; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.background = "white";
        if (!e.dataTransfer?.files.length) return;
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        fileName.textContent = '';
        imgPreview.classList.add('d-none');
        if (!file) return;

        const allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/png',
            'image/jpeg'
        ];
        if (!allowed.includes(file.type)) {
            Swal.fire({ icon: 'error', title: 'Format Salah', text: 'Gunakan format PDF, DOC, DOCX, JPG, atau PNG' });
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

    // Hapus Upload
    $(document).on('click', '.btn-delete-upload', function(e){
        e.preventDefault();
        let kontrakId = $(this).data('id');
        let row = $('#row-' + kontrakId);

        Swal.fire({
            title: 'Hapus Upload Kontrak?',
            text: 'Hanya status upload akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/datakontrak/' + kontrakId + '/delete-upload',
                    type: 'POST',
                    data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
                    success: function(){
                        Swal.fire('Terhapus!', 'Upload kontrak berhasil dihapus.', 'success');
                        row.fadeOut(500, function() { $(this).remove(); });
                    },
                    error: function(){
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                    }
                });
            }
        });
    });

    // Submit Kirim Dokumen
    $('#formKirim').submit(function(e){
        e.preventDefault();
        const formData = new FormData(this);
        $('#progressContainer').removeClass('d-none');

        $.ajax({
            url: "{{ route('datakontrak.kirim') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", evt => {
                    if(evt.lengthComputable){
                        let percent = Math.round((evt.loaded / evt.total) * 100);
                        $('#progressBar').css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            success: function(){
                $('#kirimModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Dokumen berhasil dikirim.', timer:2000, showConfirmButton:false });
                setTimeout(()=>location.reload(), 2000);
            },
            error: function(){
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan saat mengirim dokumen.' });
                $('#progressContainer').addClass('d-none');
            }
        });
    });

    // Edit Status
    $('#editStatusModal').on('show.bs.modal', function(event){
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const status = button.data('status');
        $('#edit_kontrak_id').val(id);
        $('#edit_status').val(status);
    });

$('#formEditStatus').submit(function(e){
    e.preventDefault();

    const id = $('#edit_kontrak_id').val();
    const newStatus = $('#edit_status').val();
    const _token = '{{ csrf_token() }}';

    $.ajax({
        url: '{{ url("datakontrak/update-status") }}/' + id,
        type: 'PUT',
        data: { status: newStatus, _token },

        success: function(res){

            $('#editStatusModal').modal('hide');

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status kontrak berhasil diupdate.',
                timer: 1500,
                showConfirmButton: false
            });

            // === Update Badge Tanpa Reload ===
            const badge = $('#status-badge-' + id);

            // Reset class
            badge.removeClass()
                 .addClass('badge') // class utama
                 .addClass(statusColor(newStatus)) // class warna dinamis
                 .text(capitalize(newStatus));     // teks

        },

        error: function(xhr){
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Kesalahan sistem saat update status.'
            });
        }
    });
});

// === Fungsi Warna Badge ===
function statusColor(status){
    switch(status){
        case 'menunggu': return 'bg-warning text-dark';
        case 'setuju': return 'bg-success';
        case 'pengiriman': return 'bg-primary';
        case 'selesai': return 'bg-secondary text-light';
        case 'diterima': return 'bg-info text-dark';
        default: return 'bg-secondary';
    }
}

// === Capitalize Text ===
function capitalize(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
}


});
</script>
@endpush

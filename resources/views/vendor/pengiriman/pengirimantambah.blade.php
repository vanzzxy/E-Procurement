@extends('vendor.layout.sidebarvendor')

@push('styles')
<style>
.dropzone-upload {
    border: 2px dashed #0d6efd;
    padding: 40px;
    border-radius: 12px;
    background: #f4f8ff;
    text-align: center;
    cursor: pointer;
    transition: .2s;
    min-height: 150px;
}

.dropzone-upload:hover {
    background: #e8f0ff;
}

.dropzone-upload.dragover {
    background: #d9e6ff;
    border-color: #0a58ca;
}

#previewArea img {
    max-width: 200px;
    margin-top: 10px;
}

#previewArea .file-info {
    padding: 12px;
    background: #eef5ff;
    border-radius: 6px;
    display: inline-block;
    margin-top: 10px;
}

#previewArea iframe {
    width: 100%;
    height: 250px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
}

#previewArea img {
    max-width: 220px;
    border-radius: 8px;
}


</style>
@endpush

@section('content')

<div class="main-content p-4">

    <h3 class="mb-4">Form Pengiriman Barang</h3>

    <form action="{{ route('vendor.pengiriman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- ROW 1 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nomor Surat Jalan</label>
                        <input type="text" name="no_surat_jalan" class="form-control" placeholder="Masukkan Nomor Surat Jalan" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>No. Purchase Order</label>
<select id="selectPO" name="no_purchaseorder" class="form-control" required {{ $purchaseOrders->isEmpty() ? 'disabled' : '' }}>
    
    @if($purchaseOrders->isEmpty())
        <option value="">Belum ada kontrak yang disetujui</option>
    @else
        <option value="">-- Pilih Purchase Order --</option>
        @foreach($purchaseOrders as $po)
            <option 
                value="{{ $po->no_purchaseorder }}" 
                data-kontrak="{{ $po->kontrak_id }}">
                {{ $po->no_purchaseorder }}
            </option>
        @endforeach
    @endif

</select>

                    </div>
                </div>

                {{-- ROW 2 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>No. Polisi Armada</label>
                        <input type="text" name="no_polisi" class="form-control" placeholder="Masukkan Nomor Polisi Armada" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Nama Sopir</label>
                        <input type="text" name="nama_sopir" class="form-control" placeholder="Masukkan Nama Sopir" required>
                    </div>
                </div>

                {{-- ROW 3 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nomor Telepon Sopir</label>
                        <input type="text" name="telp_sopir" class="form-control" placeholder="Masukkan Nomor Telepon Sopir" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Armada</label>
                        <input type="text" name="armada" class="form-control" placeholder="Masukkan Jenis Armada" required>
                    </div>
                </div>

                {{-- Upload --}}
<div class="form-group">
    <label>Dokumen Surat Jalan</label>

    <div id="dropzone" class="dropzone-upload">
        <p id="dropText"><strong>Drag & Drop dokumen di sini</strong></p>
        <p class="text-muted" id="dropSub">atau klik untuk memilih file</p>

        {{-- PREVIEW DALAM DROPZONE --}}
        <div id="previewArea" class="mt-3"></div>

        {{-- TOMBOL HAPUS --}}
        <button type="button" id="removeFileBtn" 
                style="display:none;" 
                class="btn btn-sm btn-danger mt-3">
            Hapus File
        </button>
    </div>

    <input type="file" id="fileInput" name="dokumen_surat_jalan" class="d-none">
</div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Tabel Detail Pengiriman Barang</h5>

                <table class="table table-bordered text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>No. PO</th>
                            <th>No. Item</th>
                            <th>Kode Barang</th>
                            <th>Spesifikasi</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBarang">
                        {{-- AJAX LOAD HERE --}}
                    </tbody>
                </table>

                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-paper-plane"></i> Kirim Barang
                </button>

            </div>
        </div>

    </form>

</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("fileInput");
    const preview = document.getElementById("previewArea");
    const removeBtn = document.getElementById("removeFileBtn");
    const dropText = document.getElementById("dropText");
    const dropSub = document.getElementById("dropSub");

    const maxSize = 5 * 1024 * 1024; // 5 MB
    const allowedExt = ["jpg","jpeg","png","pdf"];
    
    function resetDropzone() {
        preview.innerHTML = "";
        fileInput.value = "";
        dropText.style.display = "block";
        dropSub.style.display = "block";
        removeBtn.style.display = "none";
    }

    function validateFile(file) {

        // CEK FORMAT
        let ext = file.name.split('.').pop().toLowerCase();
        if (!allowedExt.includes(ext)) {
            alert("Format file tidak diizinkan! Hanya JPG, PNG, PDF.");
            resetDropzone();
            return false;
        }

        // CEK UKURAN
        if (file.size > maxSize) {
            alert("Ukuran file maksimal 5 MB!");
            resetDropzone();
            return false;
        }

        return true;
    }

    function showPreview(file) {
        preview.innerHTML = "";
        dropText.style.display = "none";
        dropSub.style.display = "none";

        let ext = file.name.split('.').pop().toLowerCase();

        // IMAGE PREVIEW
        if (["jpg", "jpeg", "png"].includes(ext)) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        }

        // PDF PREVIEW
        else if (ext === "pdf") {
            preview.innerHTML = `
                <iframe src="${URL.createObjectURL(file)}"></iframe>
            `;
        }

        // FILE LAIN
        else {
            preview.innerHTML = `
                <div class="file-info">
                    📁 <strong>${file.name}</strong>
                </div>
            `;
        }

        removeBtn.style.display = "inline-block";
    }

    // Klik → buka file picker
    dropzone.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            let file = this.files[0];
            if (validateFile(file)) showPreview(file);
        }
    });

    // Drag Over
    dropzone.addEventListener("dragover", function (e) {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", function () {
        dropzone.classList.remove("dragover");
    });

    // Drop File
    dropzone.addEventListener("drop", function (e) {
        e.preventDefault();
        dropzone.classList.remove("dragover");

        let file = e.dataTransfer.files[0];
        if (!validateFile(file)) return;

        fileInput.files = e.dataTransfer.files;
        showPreview(file);
    });

    // HAPUS FILE
    removeBtn.addEventListener("click", function () {
        resetDropzone();
    });

});

// LOAD DATA BARANG
document.addEventListener("DOMContentLoaded", function () {
    const selectPO = document.getElementById("selectPO");

    // Load berdasarkan PO pertama saat halaman dibuka
    loadBarang(selectPO.value);

    // Event ketika user ganti PO
    selectPO.addEventListener("change", function () {
        loadBarang(this.value);
    });
});

function loadBarang(po) {
    fetch(`/vendor/pengiriman/barang/${encodeURIComponent(po)}`)
        .then(res => res.json())
        .then(data => {
            const tbodyEl = document.getElementById('tableBarang');

            if (!Array.isArray(data) || data.length === 0) {
                tbodyEl.innerHTML = `<tr><td colspan="10">Data barang tidak ditemukan untuk PO ${po}</td></tr>`;
                return;
            }

            let tbody = "";
            let no = 1;

            data.forEach(item => {
                tbody += `
                    <tr>
                        <td>${no++}</td>
                        <td>${item.no_purchaseorder}</td>
                        <td>${item.item_id}</td>
                        <td>${item.kode_barang}</td>
                        <td>${item.spesifikasi}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.harga ?? '-'}</td>
                        <td>${item.satuan}</td>
                        <td><span class="badge bg-warning">Menunggu</span></td>
                        <td><input type="checkbox" name="kirim[]" value="${item.item_id}"></td>
                    </tr>
                `;
            });

            tbodyEl.innerHTML = tbody;
        })
        .catch(err => {
            console.error(err);
            document.getElementById('tableBarang').innerHTML = `<tr><td colspan="10">Terjadi error saat memuat data.</td></tr>`;
        });
}
</script>
@endpush

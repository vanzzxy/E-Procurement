@extends('admin.layout.sidebaradmin')

@section('tittle', "Tambah Kontrak || PT.INKA Multi Solusi E-Procurement")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/buatkontrak.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .row-selected {
        background-color: #e8f5e9 !important;
        transition: 0.2s;
    }

    /* Highlight input error */
    .input-error {
        border: 2px solid red !important;
        background-color: #ffe6e6;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">

    <h3 class="text-center mb-4">Form Buat Kontrak</h3>

<form id="formKontrak" method="POST">
    @csrf
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Nomor Purchase Order</label>
                <input type="text" class="form-control" id="purchaseOrder" name="no_purchaseorder" required>
            </div>

            <div class="form-group">
                <label>Kategori Barang</label>
                <select class="form-control" id="kategoriBarang" name="kategori_barang" required>
                    <option value="">-- Pilih Kategori --</option>
                </select>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Perusahaan</label>
                <select class="form-control" id="namaPerusahaan" name="vendor_id" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary float-right mt-3">Tambah</button>

    <h4 class="mt-4">Tabel Data Barang</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tabelBarang">
            <thead>
                <tr>
                    <th class="text-center">Pilih</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Spesifikasi</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody id="tbodyBarang"></tbody>
        </table>
    </div>
</form>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const perusahaanSelect = document.getElementById('namaPerusahaan');
    const kategoriSelect   = document.getElementById('kategoriBarang');
    const tbody            = document.getElementById('tbodyBarang');
    const deadlineInput    = document.getElementById('deadline');
    const purchaseOrder    = document.getElementById('purchaseOrder');

    // ====== Load kategori berdasarkan vendor ======
    perusahaanSelect.addEventListener('change', function() {
        const vendorId = this.value;

        kategoriSelect.innerHTML = `<option value="">-- Pilih Kategori --</option>`;
        tbody.innerHTML = "";

        perusahaanSelect.classList.remove('input-error');

        if (!vendorId) return;

        fetch(`/vendor/${vendorId}/kategori`)
            .then(res => res.json())
            .then(data => {
                kategoriSelect.innerHTML = `<option value="">-- Pilih Kategori --</option>`;
                data.forEach(k => {
                    kategoriSelect.innerHTML += `<option value="${k}">${k}</option>`;
                });
            })
            .catch(err => console.error(err));
    });

    // ====== LOAD BARANG BERDASARKAN KATEGORI ======
    function loadBarang(kategori) {
        kategoriSelect.classList.remove('input-error');
        if(!kategori) {
            tbody.innerHTML = "";
            return;
        }

        fetch(`/buatkontrak/barang/${kategori}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = "";

                data.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="barang-check" value="${item.id_masterbarang}">
                            </td>
                            <td>${item.kode_barang}</td>
                            <td>${item.nama_barang}</td>
                            <td>${item.spesifikasi ?? ''}</td>
                            <td>${item.satuan ?? ''}</td>
                        </tr>
                    `;
                });

                enableRowClickFeature();
            })
            .catch(err => console.error(err));
    }

    kategoriSelect.addEventListener('change', function() {
        loadBarang(this.value);
    });

    // ====== Fitur klik baris ======
    function enableRowClickFeature() {
        document.querySelectorAll('#tabelBarang tbody tr').forEach(row => {

            row.addEventListener('click', function (e) {
                if (e.target.type === 'checkbox') return;

                const checkbox = this.querySelector('.barang-check');
                checkbox.checked = !checkbox.checked;
                this.classList.toggle('row-selected', checkbox.checked);
            });

            const checkbox = row.querySelector('.barang-check');
            checkbox.addEventListener('change', function () {
                row.classList.toggle('row-selected', this.checked);
            });
        });
    }

    // ====== Hapus highlight saat user interaksi ======
    [purchaseOrder, perusahaanSelect, kategoriSelect, deadlineInput].forEach(el => {
        el.addEventListener('input', () => el.classList.remove('input-error'));
        el.addEventListener('change', () => el.classList.remove('input-error'));
    });

    // ========== SUBMIT FORM DENGAN VALIDASI ==========
    document.getElementById('formKontrak').addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset highlight
        purchaseOrder.classList.remove('input-error');
        perusahaanSelect.classList.remove('input-error');
        kategoriSelect.classList.remove('input-error');
        deadlineInput.classList.remove('input-error');

        // Validasi setiap field
        if (!purchaseOrder.value.trim()) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Nomor Purchase Order wajib diisi!' });
            purchaseOrder.classList.add('input-error');
            purchaseOrder.focus();
            return;
        }

        if (!perusahaanSelect.value) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Nama Perusahaan wajib dipilih!' });
            perusahaanSelect.classList.add('input-error');
            perusahaanSelect.focus();
            return;
        }

        if (!kategoriSelect.value) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Kategori Barang wajib dipilih!' });
            kategoriSelect.classList.add('input-error');
            kategoriSelect.focus();
            return;
        }

        if (!deadlineInput.value) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Deadline wajib diisi!' });
            deadlineInput.classList.add('input-error');
            deadlineInput.focus();
            return;
        }

        // Validasi minimal 1 barang dipilih
        const barang_ids = Array.from(document.querySelectorAll('.barang-check:checked'))
                                .map(cb => cb.value);

        if(barang_ids.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pilih minimal 1 barang!' });
            return;
        }

        // Submit via AJAX
        const formData = new FormData(this);
        barang_ids.forEach(id => formData.append('barang_ids[]', id));

        fetch("{{ route('buatkontrak.store') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('buatkontrak.index') }}";
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: res.message });
            }
        })
        .catch(error => {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan saat menyimpan data!' });
            console.error(error);
        });
    });

});
</script>
@endpush

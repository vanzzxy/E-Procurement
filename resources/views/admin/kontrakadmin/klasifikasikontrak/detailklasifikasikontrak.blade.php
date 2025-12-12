@extends('admin.layout.sidebaradmin')

@section('tittle', "Detail Klasifikasi Kontrak || PT.INKA Multi Solusi E-Procurement")

@section('content')
<div class="container-fluid mt-4">

    {{-- Judul --}}
    <h4 class="mb-3">Detail Klasifikasi Kontrak</h4>

    {{-- Informasi Kontrak --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Kontrak</span>
            <button class="btn btn-sm btn-primary" id="btnEditInfo">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
        <div class="card-body" id="infoKontrakDisplay">
            <p><strong>No. Purchase Order:</strong> <span id="displayPO">{{ $kontrak->no_purchaseorder }}</span></p>
            <p><strong>Nama Perusahaan:</strong> {{ $kontrak->vendor->nama_perusahaan ?? '-' }}</p>
            <p><strong>Kategori Barang:</strong> {{ $kontrak->kategori_barang ?? '-' }}</p>
            <p><strong>Harga Total:</strong> <span id="total-kontrak">
                {{ $kontrak->harga_total ? 'Rp '.number_format($kontrak->harga_total,0,',','.') : '-' }}
            </span></p>
            <p><strong>Deadline:</strong> <span id="displayDeadline">{{ $kontrak->deadline ? \Carbon\Carbon::parse($kontrak->deadline)->format('Y-m-d') : '-' }}</span></p>
        </div>

        {{-- Form Edit (Hidden awalnya) --}}
        <div class="card-body d-none" id="infoKontrakEdit">
            <form id="formEditKontrak" method="POST" action="{{ route('buatkontrak.update', $kontrak->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>No. Purchase Order</label>
                    <input type="text" name="no_purchaseorder" class="form-control" value="{{ $kontrak->no_purchaseorder }}" required>
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ $kontrak->deadline ? \Carbon\Carbon::parse($kontrak->deadline)->format('Y-m-d') : '' }}" required>
                </div>

                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" class="form-control" value="{{ $kontrak->vendor->nama_perusahaan ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Kategori Barang</label>
                    <input type="text" class="form-control" value="{{ $kontrak->kategori_barang ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Harga Total</label>
                    <input type="text" class="form-control" value="{{ $kontrak->harga_total ? 'Rp '.number_format($kontrak->harga_total,0,',','.') : '-' }}" readonly>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" id="btnCancelEdit">Batal</button>
            </form>
        </div>
    </div>

    {{-- Tombol Tambah Barang --}}
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
        <i class="fas fa-plus"></i> Tambah Barang
    </button>

    {{-- Tabel Barang --}}
    <div class="card">
        <div class="card-header">
            Barang Sesuai Klasifikasi
        </div>
        <div class="card-body">
            @if($kontrak->barang->count() > 0)
            <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
<tr>
    <th style="width:48px">No</th>
    <th>No. Item</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Spesifikasi</th>
    <th>Satuan</th>
    <th style="width:120px">Jumlah</th>
    <th style="width:160px">Harga (satuan)</th>
    <th style="width:160px">Subtotal</th>
    <th style="width:140px">Aksi</th>
</tr>

                </thead>
                <tbody id="tbody-barang">
                    @foreach($kontrak->barang as $index => $barang)
                    @php
                        $jumlah = $barang->pivot->jumlah ?? 0;
                        $harga = $barang->pivot->harga ?? 0;
                        $subtotal = $jumlah * $harga;
                    @endphp
                    <tr data-barang-id="{{ $barang->id_masterbarang }}"
                        data-harga="{{ $harga }}"
                        data-jumlah="{{ $jumlah }}">
<td>{{ $index + 1 }}</td>
<td>{{ $barang->id_masterbarang }}</td>
<td>{{ $barang->kode_barang }}</td>
<td>{{ $barang->nama_barang }}</td>
<td>{{ $barang->spesifikasi ?? '-' }}</td>
<td>{{ $barang->satuan ?? '-' }}</td>
<td class="text-right">{{ number_format($jumlah,0,',','.') }}</td>
<td class="text-right">{{ 'Rp '.number_format($harga,0,',','.') }}</td>
<td class="text-right" data-subtotal>{{ 'Rp '.number_format($subtotal,0,',','.') }}</td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-edit" data-barang-id="{{ $barang->id_masterbarang }}"
                                    data-bs-toggle="modal"  data-bs-target="#edit{{ $barang->id_masterbarang }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('buatkontrak.barang.delete', [$kontrak->id, $barang->id_masterbarang]) }}"
                                    method="POST" class="d-inline form-delete-item">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete-item">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @else
            <p class="text-center">Belum ada barang yang dipilih untuk kontrak ini.</p>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-3">
        <a href="{{ route('buatkontrak.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

</div>

{{-- Modal Tambah Barang --}}
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('buatkontrak.barang.add', $kontrak->id) }}" class="barang-form modal-form-add">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="masterbarang_id" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($semuaBarang as $b)
                                <option value="{{ $b->id_masterbarang }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Harga (satuan)</label>
                        <input type="text" name="harga" class="form-control format-rupiah input-harga" value="" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" class="form-control format-rupiah input-jumlah" value="1" required>
                    </div>

                    <div class="form-group">
                        <label>Subtotal (preview)</label>
                        <input type="text" class="form-control input-subtotal format-rupiah" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ==== MODALS EDIT BARANG ==== --}}
@foreach($kontrak->barang as $barang)
<div class="modal fade" id="edit{{ $barang->id_masterbarang }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('buatkontrak.barang.update', [$kontrak->id, $barang->id_masterbarang]) }}" class="barang-form modal-form-edit">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang — {{ $barang->nama_barang }}</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Harga (satuan)</label>
                        <input type="text" name="harga" class="form-control input-harga format-rupiah"
                                value="{{ $barang->pivot->harga }}">
                    </div>

                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" class="form-control input-jumlah format-rupiah"
                                value="{{ $barang->pivot->jumlah }}" required>
                    </div>

                    <div class="form-group">
                        <label>Subtotal (preview)</label>
                        <input type="text" class="form-control input-subtotal format-rupiah" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<script>
/* ============================================
   Helper: Format & Parse Rupiah
============================================ */
function formatRupiahStr(value) {
    if (value === undefined || value === null) return '';
    let s = String(value).replace(/\D/g, '');
    if (s === '') return '';
    return s.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function cleanNumberStr(formatted) {
    if (!formatted) return '0';
    return String(formatted).replace(/[^0-9]/g, '');
}


/* ============================================
   Hitung Subtotal
============================================ */
function calcSubtotal(jumlahFormatted, hargaFormatted) {
    const j = parseInt(cleanNumberStr(jumlahFormatted)) || 0;
    const h = parseInt(cleanNumberStr(hargaFormatted)) || 0;
    return j * h;
}


/* ============================================
   Update Total Kontrak dari tabel (UI)
============================================ */
function updateTotalKontrakFromTable() {
    let total = 0;

    document.querySelectorAll('td[data-subtotal]').forEach(td => {
        const num = parseInt(cleanNumberStr(td.innerText)) || 0;
        total += num;
    });

    const el = document.getElementById('total-kontrak');
    if (!el) return;

    el.innerText = total === 0
        ? '-'
        : 'Rp ' + formatRupiahStr(String(total));
}


/* ============================================
   Format Input Rupiah + Preview Subtotal + Clean Before Submit
============================================ */
function applyFormattersIn(container) {
    container.querySelectorAll('.format-rupiah').forEach(input => {

        // hindari event ganda
        if (input.dataset.rupiahInited) return;
        input.dataset.rupiahInited = '1';

        // format awal
        input.value = formatRupiahStr(input.value);

        // format saat mengetik
        input.addEventListener('input', function () {
            let caret = this.selectionStart;
            let before = this.value.length;

            this.value = formatRupiahStr(this.value);

            let after = this.value.length;
            let diff = after - before;

            try {
                this.setSelectionRange(caret + diff, caret + diff);
            } catch (e) {}

            // update preview subtotal bila ada
            const form = this.closest('.barang-form');
            if (form) {
                const jumlah = form.querySelector('.input-jumlah');
                const harga  = form.querySelector('.input-harga');
                const sub    = form.querySelector('.input-subtotal');

                if (jumlah && harga && sub) {
                    // langsung set subtotal saat ada input
                    const subtotal = calcSubtotal(jumlah.value, harga.value);
                    sub.value = formatRupiahStr(String(subtotal));
                }
            }
        });

        // saat submit → bersihkan value
        const parentForm = input.closest('form');
        if (parentForm && !parentForm.dataset.rupiahSubmitHook) {
            parentForm.dataset.rupiahSubmitHook = '1';

            parentForm.addEventListener('submit', function () {
                parentForm.querySelectorAll('.format-rupiah').forEach(inp => {
                    inp.value = cleanNumberStr(inp.value);
                });
            });

        }
    });
}


/* ============================================
   Init saat halaman load
============================================ */
document.addEventListener('DOMContentLoaded', function () {
    applyFormattersIn(document);

    // hitung total kontrak awal
    updateTotalKontrakFromTable();

    // attach click handler to edit buttons to prefill modal (if needed)
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const tr = this.closest('tr');
            const harga = tr.dataset.harga || 0;
            const jumlah = tr.dataset.jumlah || 0;
            const modalId = this.getAttribute('data-target');
            const modal = document.querySelector(modalId);
            if (!modal) return;

            // set values formatted
            const inputHarga = modal.querySelector('input[name="harga"]');
            const inputJumlah = modal.querySelector('input[name="jumlah"]');
            const inputSub = modal.querySelector('.input-subtotal');

            if (inputHarga) inputHarga.value = formatRupiahStr(String(harga));
            if (inputJumlah) inputJumlah.value = formatRupiahStr(String(jumlah));
            if (inputSub) inputSub.value = formatRupiahStr(String(calcSubtotal(String(jumlah), String(harga))));

            // ensure formatters applied to modal inputs (if not already)
            applyFormattersIn(modal);
        });
    });
});


/* ============================================
   Init dalam Modal Bootstrap
============================================ */
$(document).on('shown.bs.modal', '.modal', function () {
    const modal = this;
    applyFormattersIn(modal);

    const form = modal.querySelector('form.barang-form');
    if (form) {
        const jumlah = form.querySelector('.input-jumlah');
        const harga  = form.querySelector('.input-harga');
        const sub    = form.querySelector('.input-subtotal');

        if (jumlah && harga && sub) {
            // langsung set subtotal saat modal tampil
            const subtotal = calcSubtotal(jumlah.value, harga.value);
            sub.value = formatRupiahStr(String(subtotal));
        }
    }
});



/* ============================================
   SweetAlert DELETE ITEM
============================================ */
$(document).on('click', '.btn-delete-item', function (e) {
    e.preventDefault();
    const form = $(this).closest('form');

    Swal.fire({
        title: 'Hapus barang dari kontrak?',
        text: 'Barang akan dihapus dari kontrak ini. Tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33'
    }).then(result => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const btnEdit = document.getElementById('btnEditInfo');
    const btnCancel = document.getElementById('btnCancelEdit');
    const display = document.getElementById('infoKontrakDisplay');
    const editForm = document.getElementById('infoKontrakEdit');

    // Toggle edit form
    btnEdit.addEventListener('click', () => {
        display.classList.add('d-none');
        editForm.classList.remove('d-none');
    });

    btnCancel.addEventListener('click', () => {
        display.classList.remove('d-none');
        editForm.classList.add('d-none');
    });

    // SweetAlert for edit submit
    const formEditKontrak = document.getElementById('formEditKontrak');
    formEditKontrak.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Simpan perubahan?',
            text: 'No. PO dan Deadline akan diperbarui',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal'
        }).then(result => {
            if(result.isConfirmed){
                formEditKontrak.submit();
            }
        });
    });

});
</script>
@endpush

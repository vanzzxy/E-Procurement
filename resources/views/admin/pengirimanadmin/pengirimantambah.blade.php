@extends('vendor.layout.sidebarvendor')

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
                        <select id="selectPO" name="no_purchaseorder" class="form-control" required>
                            @foreach($purchaseOrders as $po)
                                <option value="{{ $po->no_purchaseorder }}" {{ $loop->first ? 'selected' : '' }}>
                                    {{ $po->no_purchaseorder }}
                                </option>
                            @endforeach
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
<input type="file" name="dokumen_surat_jalan" class="form-control">
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
document.addEventListener('DOMContentLoaded', function() {

    const selectPO = document.getElementById('selectPO');
    const tableBody = document.getElementById('tableBarang');

    if (!selectPO) return;

    // Load otomatis PO pertama
    const initialPO = selectPO.value || selectPO.options[0].value;
    if (initialPO) loadBarang(initialPO);

    // Ketika dropdown berubah
    selectPO.addEventListener('change', function() {
        if (this.value) loadBarang(this.value);
    });

});

// LOAD DATA BARANG
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

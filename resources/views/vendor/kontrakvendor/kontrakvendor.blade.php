@extends('vendor.layout.sidebarvendor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vendor/kontrak.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .modal-content {
        background: #fff;
        padding: 25px;
        width: 400px;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.3);
    }
    .modal-buttons {
        margin-top: 15px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .modal-buttons .btn {
        padding: 8px 18px;
    }
</style>
@endpush

@section('tittle', "Kontrak Vendor")

@section('content')
<div class="main-content">
    <h1 class="section-title">KONTRAK VENDOR</h1>

    <div class="table-container">
        <div class="search-container">
            <input type="text" class="form-control search-input" placeholder="Search" />
            <button class="btn btn-primary search-button"><i class="fas fa-search"></i></button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Kontrak</th>
                    <th>No. Purchase Order</th>
                    <th>Kategori Barang</th>
                    <th>Harga Total</th>
                    <th>Batas Akhir Diterima</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($kontrak as $row)
                @foreach ($row->datakontrak as $item)
                <tr>
                    <td>{{ $item->id }}</td>

                    {{-- ID Kontrak --}}
                    <td>{{ $item->id }}</td>

                    {{-- Purchase Order --}}
                    <td>{{ $item->no_purchaseorder }}</td>

                    {{-- Kategori Barang --}}
                    <td>{{ $item->kategori_barang ?? '-' }}</td>

                    {{-- Harga Total --}}
                    <td>
                        {{ $item->harga_total 
                            ? 'Rp ' . number_format($item->harga_total, 0, ',', '.')
                            : '-' 
                        }}
                    </td>
                    {{-- Deadline --}}
                    <td>
    {{
        $item->deadline
        ? \Carbon\Carbon::parse($item->deadline)->format('d/m/Y')
        : ($item->kontrak && $item->kontrak->deadline
            ? \Carbon\Carbon::parse($item->kontrak->deadline)->format('d/m/Y')
            : '-')
    }}
</td>



                    {{-- STATUS --}}
                    {{-- STATUS --}}
<td>
    @php $status = $item->status ?? '-'; @endphp
    @include('vendor.layout.status_badge', ['status' => $status, 'id' => $item->id])

</td>


<td>

    {{-- TOMBOL DOWNLOAD --}}
<a href="{{ route('vendor.kontrak.download', $row->id) }}" 
   class="btn-action download">
    <i class="fas fa-download"></i>
</a>


    {{-- TOMBOL LIHAT --}}
    <a href="{{ route('vendor.kontrak.detail', $row->id) }}" class="btn-action view">
        <i class="fas fa-eye"></i>
    </a>

    {{-- TOMBOL SETUJU – hanya tampil jika status masih menunggu atau setuju --}}
    @if (in_array($item->status, ['menunggu', 'setuju']))
        <a href="#"
           class="btn-action setuju"
           data-id="{{ $item->id }}"
           onclick="setujuiKontrak(this)">
           <i class="fas fa-check"></i>
        </a>
    @endif

</td>

                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- POPUP EDIT MODAL --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Edit Status Kontrak</h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <label>Status:</label>
            <select name="status" id="statusInput" class="form-control">
                <option value="menunggu">Menunggu</option>
                <option value="setuju">Setuju</option>
                <option value="pengiriman">Pengiriman</option>
                <option value="diterima">Diterima</option>
                <option value="selesai">Selesai</option>
            </select>

            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// search
document.querySelector('.search-button').addEventListener('click', function() {
    let value = document.querySelector('.search-input').value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// buka modal
function openEditModal(button) {
    let id = button.getAttribute('data-id');
    let status = button.getAttribute('data-status');

    document.getElementById('editForm').action = `/vendor/kontrak/update/${id}`;
    document.getElementById('statusInput').value = status;

    document.getElementById('editModal').style.display = 'flex';
}

// tutup
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

</script>

<script>
    function setujuiKontrak(button) {
    let id = button.getAttribute('data-id');

    Swal.fire({
        title: 'Setujui Kontrak?',
        text: 'Jika setuju, segera melakukan pengiriman.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            // Kirim AJAX update status
fetch(`/vendor/kontrak/update/${id}`, {
    method: "PUT",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "X-Requested-With": "XMLHttpRequest",
        "Accept": "application/json"
    },
    body: JSON.stringify({ status: "setuju" })
})

            .then(response => response.json())
            .then(data => {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Status telah diupdate menjadi SETUJU.',
                    timer: 1500,
                    showConfirmButton: false
                });

                // Redirect ke halaman pengiriman setelah 1.5 detik
                setTimeout(() => {
                    window.location.href = "{{ route('vendor.pengiriman') }}";
                }, 1500);

            })
            .catch(error => {
                Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
            });
        }

    });
}

</script>
@endpush


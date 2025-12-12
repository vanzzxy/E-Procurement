@extends('admin.layout.sidebaradmin')

@section('tittle', "Daftar Vendor")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/daftarvendor.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@endpush

@section('content')
<div class="main-content">
    <h1>DAFTAR VENDOR</h1>
    <div class="underline"></div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#buatDcrModal">
            <i class="fa fa-plus"></i> Buat DCR
        </button>
    </div>

    <div class="table-container">
        <table id="vendorTable" class="display table table-striped table-bordered w-100">
            <thead>
                <tr>
                    <th>ID Vendor</th>
                    <th>Nama Perusahaan</th>
                    <th>Tools</th>
                    <th>Consumable</th>
                    <th>Material</th>
                    <th>Raw Material</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                    @php $kategori = json_decode($vendor->kategori_perusahaan); @endphp
                    <tr>
                        <td>{{ $vendor->id_vendor }}</td>
                        <td>{{ $vendor->nama_perusahaan }}</td>

                        <td>{!! in_array('Tools', $kategori) ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!}</td>
                        <td>{!! in_array('Consumable', $kategori) ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!}</td>
                        <td>{!! in_array('Material', $kategori) ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!}</td>
                        <td>{!! in_array('Raw Material', $kategori) ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!}</td>

                        <td class="text-center">
                            <a href="{{ route('vendor.detail', $vendor->id_vendor) }}" class="btn btn-sm text-dark" title="Lihat">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- ========================= MODAL BUAT DCR ========================= --}}
<div class="modal fade" id="buatDcrModal" tabindex="-1" aria-labelledby="buatDcrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Buat Daftar Calon Rekanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formBuatDcr">

                @csrf

                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label class="fw-bold">Kode Daftar Calon Rekanan</label>
                        <input type="text" name="kode_dcr" class="form-control" placeholder="Masukkan kode" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-bold">Nama Daftar Calon Rekanan</label>
                        <input type="text" name="nama_dcr" class="form-control" placeholder="Masukkan nama" required>
                    </div>

                    {{-- Pilihan Vendor --}}
                    <div class="form-group">
                        <label class="fw-bold">Pilih Vendor</label>
                        <div class="row">

                            {{-- Kiri: Daftar Vendor --}}
                            <div class="col-md-6 vendor-column p-3 border rounded" style="height:250px; overflow-y:auto;">
                                
                                {{-- Search --}}
                                <input type="text" id="vendorSearch" class="form-control form-control-sm mb-2" placeholder="Cari vendor...">

                                {{-- Select / Deselect --}}
                                <div class="mb-2 d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-primary" id="selectAllVendors">Pilih Semua</button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="deselectAllVendors">Hapus Semua</button>
                                </div>

                                <ul id="vendorList" class="list-unstyled">
                                    @foreach($vendors as $vendor)
                                        <li class="vendor-item d-flex align-items-center py-1 border-bottom"
                                            draggable="true" data-id="{{ $vendor->id_vendor }}"
                                            style="cursor:grab;">
                                            <input class="vendor-checkbox me-2" type="checkbox" value="{{ $vendor->id_vendor }}">
                                            <label class="m-0">{{ $vendor->nama_perusahaan }}</label>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>

                            {{-- Kanan: Vendor terpilih --}}
                            <div class="col-md-6 vendor-column p-3 border rounded" style="height:250px; overflow-y:auto;">
                                <label class="fw-bold">Vendor Terpilih:</label>
                                <ul id="selectedVendors" class="list-unstyled mt-2" style="min-height:200px; border-top:1px dashed #ccc;"></ul>
                            </div>

                        </div>

                        <input type="hidden" name="vendor_ids" id="vendor_ids">
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- ================================================================ --}}
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ALERT DATA --}}
@if (session('dcr_success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('dcr_success') }}",
    timer: 1800,
    showConfirmButton: false
});
</script>
@endif

@if (session('dcr_error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('dcr_error') }}",
    confirmButtonColor: '#d33'
});
</script>
@endif


{{-- LOGIC DRAG, SELECT, FILTER --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const vendorList = document.getElementById("vendorList");
    const selectedVendors = document.getElementById("selectedVendors");
    const hiddenInput = document.getElementById("vendor_ids");
    const selectAllBtn = document.getElementById("selectAllVendors");
    const deselectAllBtn = document.getElementById("deselectAllVendors");
    const vendorSearch = document.getElementById("vendorSearch");

    let draggedItem = null;
    let isDragging = false;

    /* ---------- Helper Functions ---------- */
    function updateSelectedFromCheckboxes() {
        selectedVendors.innerHTML = "";
        const selected = [];
        vendorList.querySelectorAll("li").forEach(li => {
            const cb = li.querySelector(".vendor-checkbox");
            if (cb && cb.checked) {
                selected.push(cb.value);

                const newLi = document.createElement("li");
                newLi.className = "py-1";
                newLi.textContent = li.querySelector("label").textContent.trim();
                newLi.dataset.id = cb.value;
                newLi.setAttribute("draggable", "true");

                addDragHandlersToItem(newLi);
                selectedVendors.appendChild(newLi);
            }
        });

        hiddenInput.value = selected.join(",");
    }

    function addDragHandlersToItem(li) {
        if (li.dataset.dragHandlersAdded) return;
        li.dataset.dragHandlersAdded = "1";

        li.addEventListener("dragstart", function (e) {
            draggedItem = li;
            isDragging = true;
            try { e.dataTransfer.setData('text/plain', li.dataset.id || ''); } catch {}
            e.dataTransfer.effectAllowed = "move";
        });

        li.addEventListener("dragend", function () {
            draggedItem = null;
            setTimeout(() => isDragging = false, 50);
        });
    }

    function attachDragToVendorListItems() {
        vendorList.querySelectorAll("li").forEach(li => {
            li.setAttribute("draggable", "true");
            addDragHandlersToItem(li);
        });
    }

    /* ---------- Drop Zones ---------- */
    vendorList.addEventListener("dragover", e => e.preventDefault());
    selectedVendors.addEventListener("dragover", e => e.preventDefault());

    selectedVendors.addEventListener("drop", function (e) {
        e.preventDefault();
        if (!draggedItem) return;
        const id = draggedItem.dataset.id;
        const cb = vendorList.querySelector(`.vendor-checkbox[value="${id}"]`);
        if (cb) {
            cb.checked = true;
            updateSelectedFromCheckboxes();
        }
        draggedItem = null;
    });

    vendorList.addEventListener("drop", function (e) {
        e.preventDefault();
        if (!draggedItem) return;
        const id = draggedItem.dataset.id;
        const cb = vendorList.querySelector(`.vendor-checkbox[value="${id}"]`);
        if (cb) {
            cb.checked = false;
            updateSelectedFromCheckboxes();
        }
        draggedItem = null;
    });

    /* ---------- Click Toggle ---------- */
    vendorList.addEventListener("click", function (e) {
        if (e.target.matches('.vendor-checkbox')) {
            updateSelectedFromCheckboxes();
            return;
        }

        const li = e.target.closest('li');
        if (!li || isDragging) return;

        const cb = li.querySelector('.vendor-checkbox');
        if (cb) {
            cb.checked = !cb.checked;
            updateSelectedFromCheckboxes();
        }
    });

    /* ---------- Select / Deselect All ---------- */
    selectAllBtn.addEventListener("click", function () {
        vendorList.querySelectorAll(".vendor-checkbox").forEach(cb => cb.checked = true);
        updateSelectedFromCheckboxes();
    });

    deselectAllBtn.addEventListener("click", function () {
        vendorList.querySelectorAll(".vendor-checkbox").forEach(cb => cb.checked = false);
        updateSelectedFromCheckboxes();
    });

    /* ---------- Search Filter ---------- */
    function debounce(fn, wait) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function applySearchFilter() {
        const query = vendorSearch.value.trim().toLowerCase();
        vendorList.querySelectorAll("li").forEach(li => {
            const name = li.querySelector("label").textContent.toLowerCase();
            li.style.display = name.includes(query) ? "" : "none";
        });
    }

    // Pasang listener dengan debounce
    vendorSearch.oninput = null; // hapus listener lama
    vendorSearch.addEventListener("input", debounce(applySearchFilter, 150));

    /* ---------- Initialization ---------- */
    attachDragToVendorListItems();
    updateSelectedFromCheckboxes();

    // Jalankan filter langsung jika ada value
    applySearchFilter();
});

</script>


<script>
$(document).ready(function () {
    const table = $('#vendorTable').DataTable();

    $("#formBuatDcr").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('dcr.store.ajax') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: res.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Tutup modal
                $("#buatDcrModal").modal("hide");

                // Reset form
                $("#formBuatDcr")[0].reset();
                $("#selectedVendors").empty();
                $("#vendor_ids").val("");

                // Reload / redraw table
                table.draw(false);
            },

            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: xhr.responseJSON?.message ?? "Terjadi kesalahan.",
                });
            }
        });
    });
});
</script>


@endpush

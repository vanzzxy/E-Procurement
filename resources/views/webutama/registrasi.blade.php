@extends('webutama.layout.layoutwebutama')

@section('title', 'Halaman Registrasi || PT.INKA Multi Solusi E-Procurement')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/webutama/registrasi.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    /* Icon toggle password */
    .password-toggle {
        position: relative;
    }
    .password-toggle i {
        position: absolute;
        top: 65%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2rem;
        color: #555;
    }

    .file-name {
    margin-top: 8px;
    font-size: 14px;
    color: #333;
    font-weight: bold;
}

.delete-file {
    margin-top: 6px;
    background: #d9534f;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.delete-file:hover {
    background: #c9302c;
}

</style>
@endpush


@section('content')

<!-- BANNER -->
<div class="banner">
    <h2>Silahkan Registrasi terlebih dahulu sebelum masuk ke dalam E-Procurement PT.XYZ</h2>
</div>

<!-- FORM REGISTRASI -->
<main class="main-content">
    <h2 class="form-title">Registrasi Vendor</h2>

    <form class="registration-form" action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ======================== --}}
        {{-- DATA PERUSAHAAN --}}
        {{-- ======================== --}}
        <section class="form-section">
            <h3>Data Perusahaan</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Asal Perusahaan</label>
                    <select name="asal_perusahaan">
                        <option value="Lokal" {{ old('asal_perusahaan') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                        <option value="Internasional" {{ old('asal_perusahaan') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                    </select>
                    @error('asal_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>No. NPWP Perusahaan</label>
                    <input type="text" name="npwp" value="{{ old('npwp') }}" placeholder="Masukkan Kode 16 Digit" class="custom-input">
                    @error('npwp') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
<div class="inline-group">
    <div>
        <label>Jenis Badan Usaha</label>
        <select name="jenis_badan_usaha">
            <option value="PT" {{ old('jenis_badan_usaha') == 'PT' ? 'selected' : '' }}>PT</option>
            <option value="CV" {{ old('jenis_badan_usaha') == 'CV' ? 'selected' : '' }}>CV</option>
            <option value="UD" {{ old('jenis_badan_usaha') == 'UD' ? 'selected' : '' }}>UD</option>
        </select>
    </div>

    <div>
        <label>Nama Perusahaan</label>
        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Masukkan Nama Perusahaan">
    </div>
</div>

                    @error('nama_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>No. Fax</label>
                    <input type="text" name="fax" value="{{ old('fax') }}" placeholder="Masukkan Nomor Fax">
                </div>
            </div>

            {{-- File Upload Grid --}}
<div class="file-grid">
    <div class="form-group">
        <label>File NPWP Perusahaan</label>
        <div class="file-card">
            <i class="bx bx-upload"></i>
            <span>Upload File NPWP</span>
            <input type="file" name="file_npwp">
        </div>
    </div>

    <div class="form-group">
        <label>File Sertifikat ISO</label>
        <div class="file-card">
            <i class="bx bx-upload"></i>
            <span>Upload File ISO</span>
            <input type="file" name="file_iso">
        </div>
    </div>

    <div class="form-group">
        <label>File SIUP</label>
        <div class="file-card">
            <i class="bx bx-upload"></i>
            <span>Upload File SIUP</span>
            <input type="file" name="file_siup">
        </div>
    </div>

    <div class="form-group">
        <label>File SKF</label>
        <div class="file-card">
            <i class="bx bx-upload"></i>
            <span>Upload File SKF</span>
            <input type="file" name="file_skf">
        </div>
    </div>
</div>

            <div class="form-row">
                <div class="form-group">
                    <label>Alamat Perusahaan</label>
                    <input type="text" name="alamat_perusahaan" value="{{ old('alamat_perusahaan') }}" placeholder="Masukkan Alamat Perusahaan">
                    @error('alamat_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>E-mail Perusahaan</label>
                    <input type="email" name="email_perusahaan" value="{{ old('email_perusahaan') }}" placeholder="Masukkan Email Perusahaan">
                    @error('email_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>No. Telepon Perusahaan</label>
                    <input type="text" name="telepon_perusahaan" value="{{ old('telepon_perusahaan') }}" placeholder="Masukkan Nomor Telepon Perusahaan">
                    @error('telepon_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Kategori --}}
                <div class="custom-dropdown">
                    <label for="kategori">Kategori Perusahaan</label>
                    <button type="button" id="dropdownButton" class="dropdown-toggle" onclick="toggleDropdown()">Pilih Kategori</button>

                    <div id="dropdownMenu" class="dropdown-menu">
                        <label><input type="checkbox" name="kategori_perusahaan[]" value="Tools" {{ in_array('Tools', old('kategori_perusahaan', [])) ? 'checked' : '' }}> Tools</label>

                        <label><input type="checkbox" name="kategori_perusahaan[]" value="Consumable" {{ in_array('Consumable', old('kategori_perusahaan', [])) ? 'checked' : '' }}> Consumable</label>

                        <label><input type="checkbox" name="kategori_perusahaan[]" value="Raw Material" {{ in_array('Raw Material', old('kategori_perusahaan', [])) ? 'checked' : '' }}> Raw Material</label>

                        <label><input type="checkbox" name="kategori_perusahaan[]" value="Material" {{ in_array('Material', old('kategori_perusahaan', [])) ? 'checked' : '' }}> Material</label>
                    </div>

                    @error('kategori_perusahaan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Username & password --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Buat Username Akun Perusahaan">
                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group password-toggle">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Buat Password Akun Perusahaan">
                    <i class='bx bx-show' id="togglePassword"></i>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

        </section>

        {{-- ======================== --}}
        {{-- KONTAK PRIBADI 1 --}}
        {{-- ======================== --}}
        <section class="form-section">
            <h3>Kontak Pribadi 1</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="namaLengkap1" value="{{ old('namaLengkap1') }}" placeholder="Masukkan Nama Lengkap">
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan1" value="{{ old('jabatan1') }}" placeholder="Masukkan Jabatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email1" value="{{ old('email1') }}" placeholder="Masukkan Email">
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="tel" name="telepon1" value="{{ old('telepon1') }}" placeholder="Masukkan No. Telepon">
                </div>
            </div>
        </section>

        {{-- ======================== --}}
        {{-- KONTAK PRIBADI 2 --}}
        {{-- ======================== --}}
        <section class="form-section">
            <h3>Kontak Pribadi 2</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="namaLengkap2" value="{{ old('namaLengkap2') }}" placeholder="Masukkan Nama Lengkap">
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan2" value="{{ old('jabatan2') }}" placeholder="Masukkan Jabatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email2" value="{{ old('email2') }}" placeholder="Masukkan Email">
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="tel" name="telepon2" value="{{ old('telepon2') }}" placeholder="Masukkan No. Telepon">
                </div>
            </div>
        </section>

        <button type="submit" class="submit-btn">Daftar</button>
    </form>
</main>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle password show/hide
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bx-show');
        this.classList.toggle('bx-hide');
    });

    // SweetAlert feedback
    document.addEventListener('DOMContentLoaded', function () {

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Ada kesalahan dalam pengisian form. Silahkan periksa kolom yang berwarna merah.',
                confirmButtonColor: '#d33'
            });
        @endif
    });

    // Dropdown kategori
    function toggleDropdown() {
        let dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    // Update teks tombol dropdown sesuai checkbox yang dipilih
const dropdownButton = document.getElementById('dropdownButton');
const dropdownMenu = document.getElementById('dropdownMenu');

// Ketika checkbox di klik
document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Event change untuk semua checkbox
    dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateDropdownText);
    });

    function updateDropdownText() {
        // Ambil semua checkbox yang dicentang
        const selected = Array.from(dropdownMenu.querySelectorAll('input[type="checkbox"]:checked'))
            .map(cb => cb.value);

        // Update teks tombol
        dropdownButton.textContent = selected.length > 0 
            ? selected.join(', ') 
            : 'Pilih Kategori';
    }

    // Auto update jika halaman reload (OLD VALUE Laravel)
    updateDropdownText();
});

// Fitur drag & drop
document.addEventListener("DOMContentLoaded", function () {
    const fileCards = document.querySelectorAll(".file-card");

    fileCards.forEach(card => {
        const input = card.querySelector("input[type='file']");
        const labelSpan = card.querySelector("span");

        // Saat user klik pilih file biasa
        input.addEventListener("change", () => {
            handleFileSelect(input, card);
        });

        // DRAG ENTER
        card.addEventListener("dragenter", (e) => {
            e.preventDefault();
            card.classList.add("dragover");
        });

        // DRAG OVER
        card.addEventListener("dragover", (e) => {
            e.preventDefault();
            card.classList.add("dragover");
        });

        // DRAG LEAVE
        card.addEventListener("dragleave", () => {
            card.classList.remove("dragover");
        });

        // DROP
        card.addEventListener("drop", (e) => {
            e.preventDefault();
            card.classList.remove("dragover");

            if (e.dataTransfer.files.length > 1) {
                Swal.fire({
                    icon: "error",
                    title: "Maksimal 1 file!",
                    text: "Silakan masukkan hanya satu file.",
                });
                return;
            }

            if (e.dataTransfer.files.length === 1) {
                input.files = e.dataTransfer.files; 
                handleFileSelect(input, card);
            }
        });
    });

    // FUNGSI HANDLING FILE
    function handleFileSelect(input, card) {
        // Hapus nama file lama jika ada
        const oldFileName = card.parentElement.querySelector(".file-name");
        if (oldFileName) oldFileName.remove();

        // Hapus tombol hapus lama
        const oldDeleteBtn = card.parentElement.querySelector(".delete-file");
        if (oldDeleteBtn) oldDeleteBtn.remove();

        // Tampilkan nama file baru
        if (input.files.length > 0) {
            const fileNameDiv = document.createElement("div");
            fileNameDiv.classList.add("file-name");
            fileNameDiv.textContent = input.files[0].name;

            const deleteBtn = document.createElement("button");
            deleteBtn.classList.add("delete-file");
            deleteBtn.textContent = "Hapus File";

            deleteBtn.addEventListener("click", () => {
                input.value = ""; // reset file input
                fileNameDiv.remove();
                deleteBtn.remove();
            });

            card.parentElement.appendChild(fileNameDiv);
            card.parentElement.appendChild(deleteBtn);
        }
    }
});


</script>
@endpush

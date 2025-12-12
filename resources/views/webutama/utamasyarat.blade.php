@extends('webutama.layout.layoutwebutama')

@section('title', 'Halaman Aturan & Syarat || PT.INKA Multi Solusi E-Procurement')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/webutama/syarat.css') }}">
@endpush

@section('content')

<div class="neu-container">
    <section class="neu-section dark">
        <h2>Aturan</h2>
        <h3>Aturan penggunaan Website Sistem Manajemen Vendor PT. XYZ</h3>
<p>
    Pengguna wajib memahami bahwa seluruh layanan dalam Sistem Manajemen Vendor PT. XYZ 
    disediakan untuk mendukung proses pengadaan perusahaan. Dengan mengakses website ini, 
    pengguna menyetujui bahwa seluruh data, dokumen, dan informasi yang diunggah merupakan 
    data yang valid, sah, dan dapat dipertanggungjawabkan sesuai peraturan perusahaan.

    PT. XYZ berhak melakukan verifikasi, peninjauan, ataupun penolakan atas data vendor 
    apabila ditemukan ketidaksesuaian, indikasi kecurangan, atau pelanggaran terhadap ketentuan 
    internal maupun peraturan perundang-undangan yang berlaku.

    Seluruh aktivitas pengguna pada sistem ini akan terekam otomatis untuk keperluan audit 
    internal dan peningkatan kualitas layanan.
</p>
    </section>

    <section class="neu-section light">
        <h2>Syarat</h2>
        <h3>Syarat penggunaan Website Sistem Manajemen Vendor PT. XYZ</h3>
<p>
    Website Sistem Manajemen Vendor PT. XYZ digunakan sebagai pusat informasi, pendaftaran, 
    serta pemutakhiran data vendor resmi perusahaan. Dengan menggunakan platform ini, pengguna 
    menyatakan setuju untuk mengikuti seluruh kebijakan keamanan informasi, standar integritas, 
    serta ketentuan yang ditetapkan perusahaan.

    PT. XYZ tidak bertanggung jawab atas kerugian yang timbul akibat kelalaian pengguna dalam 
    menjaga kerahasiaan akun, termasuk penyalahgunaan akses oleh pihak lain yang memperoleh 
    kredensial login secara tidak sah. Pengguna wajib segera melaporkan kepada pihak pengelola 
    apabila terjadi percobaan akses ilegal atau pelanggaran keamanan lainnya.

    Data yang dikirimkan melalui sistem ini akan digunakan untuk proses verifikasi legalitas, 
    evaluasi kualifikasi, dan penilaian kinerja vendor sesuai kebutuhan unit pengadaan. 
    PT. XYZ berhak memperbarui ketentuan penggunaan sistem ini sewaktu-waktu tanpa pemberitahuan 
    sebelumnya demi kepatuhan terhadap standar perusahaan maupun regulasi pemerintah.

    Dengan melanjutkan penggunaan platform ini, pengguna dianggap telah membaca, memahami, 
    dan menyetujui seluruh aturan, syarat, serta konsekuensi yang berlaku.
</p>

    </section>
</div>

@endsection

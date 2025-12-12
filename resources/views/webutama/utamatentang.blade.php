@extends('webutama.layout.layoutwebutama')

@section('title', 'Halaman Tentang Kami || PT. XYZ E-Procurement')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/webutama/tentang.css') }}">
@endpush

@section('content')

<div class="content">
    <section class="about-section">
        <div class="text">
            <h2 class="custom-header">E-Procurement<br>PT.XYZ</h2>
<p>
    Sistem e-procurement PT XYZ dirancang untuk meningkatkan efisiensi, akurasi, 
    dan transparansi dalam proses pengadaan barang dan jasa perusahaan. 
    Dengan penerapan teknologi digital, seluruh proses pengadaan dapat dilakukan secara 
    terintegrasi, mulai dari pengajuan kebutuhan, proses penawaran, seleksi vendor, 
    hingga finalisasi kontrak.<br><br>
    Platform ini juga memberikan kemudahan bagi vendor untuk mendaftar, memperbarui data, 
    serta mengikuti proses pengadaan secara daring tanpa harus hadir secara fisik. 
    Sistem ini menjadi bagian penting dalam mendukung komitmen perusahaan terhadap praktik 
    pengadaan yang bersih, kompetitif, dan profesional.
</p>

        </div>
        <div class="image-box">
            <iframe width="560" height="315"
                src="https://www.youtube.com/embed/vbbxiDDYiyk?autoplay=1&loop=1&playlist=vbbxiDDYiyk&mute=1">
            </iframe>
        </div>
    </section>
</div>

<section class="header-section">
    <h2 class="section-header">Tentang E-Procurement PT. XYZ</h2>
</section>

<section class="info-section">
    <div class="info-header-box">
<p>
    Selamat datang di PT XYZ E-Procurement, platform resmi pengadaan barang dan jasa 
    yang dikembangkan untuk mendukung operasional perusahaan secara efisien dan terstandarisasi. 
    Sistem ini memungkinkan seluruh proses pengadaan dilakukan secara online, 
    sehingga lebih cepat, terstruktur, dan mudah dipantau.
</p>

<p>
    PT XYZ berkomitmen menghadirkan proses pengadaan yang akuntabel, transparan, dan kompetitif. 
    Melalui sistem ini, perusahaan memastikan bahwa setiap vendor memiliki kesempatan yang sama 
    dalam mengikuti proses pengadaan, sesuai dengan prinsip tata kelola perusahaan yang baik 
    (Good Corporate Governance).
</p>

    </div>
</section>

<section class="header-section">
    <h2 class="section-header">Visi Misi E-Procurement PT. XYZ</h2>
</section>

<section class="info-section">
    <div class="info-header-box">
<p>
    Visi kami adalah menjadi platform pengadaan digital yang modern, terpercaya, dan efisien 
    dalam mendukung kebutuhan operasional perusahaan. Kami berupaya memastikan proses pengadaan 
    berjalan sesuai standar kualitas, transparansi, dan regulasi yang berlaku.
</p>

<p>
    Misi kami adalah menyediakan ekosistem pengadaan yang inklusif bagi vendor, 
    memastikan proses seleksi yang objektif, serta menciptakan kolaborasi yang saling 
    menguntungkan antara perusahaan dan mitra usaha. Sistem ini terus dikembangkan 
    untuk memberikan pengalaman yang lebih mudah, aman, dan cepat.
</p>

<p>
    Dengan teknologi yang terus diperbarui, PT XYZ berkomitmen meningkatkan efisiensi internal, 
    meminimalkan risiko penyimpangan, serta memperkuat integritas dalam seluruh aktivitas 
    pengadaan. Hal ini dilakukan demi mendukung keberlangsungan bisnis perusahaan
    secara berkelanjutan.
</p>

    </div>
</section>

<section class="header-section">
    <h2 class="section-header">FAQ (Frequently Asked Questions)</h2>
</section>

<section class="faq-section">
    <div class="info-header-box faq-box">
        <details>
            <summary>Apa saja langkah-langkah untuk memulai proses pengadaan?</summary>
<p>
    Untuk memulai proses pengadaan, pengguna harus memastikan data perusahaan dan dokumen legal 
    telah lengkap dan valid. Setelah itu, vendor dapat mengikuti proses registrasi, menunggu 
    verifikasi, kemudian mengakses paket pengadaan yang tersedia dalam sistem sesuai kualifikasi.
</p>

        </details>
        <details>
            <summary>Bagaimana memantau status pengadaan?</summary>
<p>
    Status pengadaan dapat dipantau langsung melalui dashboard vendor. Sistem akan menampilkan 
    tahapan proses yang sedang berjalan, seperti evaluasi, klarifikasi, maupun penetapan pemenang.
    Semua pembaruan status ditampilkan secara real-time.
</p>
        </details>
        <details>
            <summary>Bagaimana menjadi vendor?</summary>
<p>
    Untuk menjadi vendor resmi, perusahaan harus mengajukan pendaftaran melalui menu registrasi 
    vendor, mengunggah dokumen legalitas, dan melengkapi data administrasi serta teknis. 
    Setelah proses verifikasi selesai, vendor dapat berpartisipasi dalam pengadaan yang tersedia.
</p>
        </details>
    </div>
</section>

@endsection

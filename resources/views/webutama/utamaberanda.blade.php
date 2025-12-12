@extends('webutama.layout.layoutwebutama')
@section('title', 'Halaman Beranda')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/webutama/beranda.css') }}">
@endpush

@section('content')

<div class="content">

    <section class="hero-section">
        <h1>Selamat Datang di E-Procurement PT. XYZ</h1>
        <p>Di PT XYZ, kami bangga menjadi mitra pengadaan yang andal untuk memenuhi kebutuhan bisnis Anda.</p>
    </section>

    <section class="image-section">
        <img src="{{ asset('img/ppberanda.png') }}" alt="Gambar">
    </section>

    <section class="about-section">
        <h2>Mengapa Memilih Kami?</h2>
        <p>Kami tidak hanya menawarkan akses kepada produk dan layanan berkualitas tinggi, tetapi juga menyediakan
            pengalaman transaksi yang aman, efisien, dan terpercaya.</p>
        <ul>
            <li>Keamanan Transaksi Terjamin: Setiap transaksi dijamin keamanannya.</li>
            <li>Kemitraan yang Membangun: Kami membangun kemitraan jangka panjang.</li>
            <li>Inovasi dalam Pengadaan: Solusi inovatif yang mendukung bisnis Anda.</li>
        </ul>
    </section>

    <section class="clients-section">
        <h2>Beberapa Pelanggan PT. XYZ</h2>
        <div class="clients-carousel">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 1">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 2">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 3">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 4">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 5">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 6">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 7">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 8">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 9">
            <img src="{{ asset('img/xyz.jpg') }}" alt="Client 10">
        </div>
    </section>

    <section class="cta-section">
        <h1>Mulai Pengalaman Pengadaan Anda Sekarang!</h1>
        <button class="btn cta-btn" onclick="location.href='halamanlogin'">Mulai Sekarang</button>
    </section>

</div>

@endsection

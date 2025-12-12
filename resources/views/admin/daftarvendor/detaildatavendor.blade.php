@extends('admin.layout.sidebaradmin')

@section('tittle', "Detail Data Vendor")

@section('content')
<div class="container-fluid">

    <h2 class="mb-3">Detail Data Vendor</h2>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <table class="table table-bordered">

        {{-- Informasi Perusahaan --}}
        <tr><th colspan="2" class="bg-dark text-white">Informasi Perusahaan</th></tr>
        <tr><th>ID Vendor</th><td>{{ $vendor->id_vendor }}</td></tr>
        <tr><th>Asal Perusahaan</th><td>{{ $vendor->asal_perusahaan ?? '-' }}</td></tr>
        <tr><th>Nama Perusahaan</th><td>{{ $vendor->nama_perusahaan ?? '-' }}</td></tr>
        <tr><th>Jenis Badan Usaha</th><td>{{ $vendor->jenis_badan_usaha ?? '-' }}</td></tr>
        <tr><th>NPWP</th><td>{{ $vendor->npwp ?? '-' }}</td></tr>
        <tr><th>Fax</th><td>{{ $vendor->fax ?? '-' }}</td></tr>
        <tr><th>Alamat Perusahaan</th><td>{{ $vendor->alamat_perusahaan ?? '-' }}</td></tr>
        <tr><th>Email Perusahaan</th><td>{{ $vendor->email_perusahaan ?? '-' }}</td></tr>
        <tr><th>Telepon Perusahaan</th><td>{{ $vendor->telepon_perusahaan ?? '-' }}</td></tr>

        {{-- Kategori --}}
        <tr>
            <th>Kategori Perusahaan</th>
            <td>
                @php
                    $kategori = json_decode($vendor->kategori_perusahaan, true);
                @endphp

                @if(is_array($kategori))
                    {{ implode(', ', $kategori) }}
                @else
                    -
                @endif
            </td>
        </tr>

        {{-- Dokumen --}}
<tr>
    <th>Dokumen NPWP</th>
    <td>
        @if($vendor->file_npwp)
            <a href="{{ asset('storage/' . $vendor->file_npwp) }}" target="_blank" class="btn btn-dark btn-sm">
                <i class="fa fa-file"></i> Lihat Dokumen
            </a>
        @else
            -
        @endif
    </td>
</tr>

<tr>
    <th>Dokumen SIUP</th>
    <td>
        @if($vendor->file_siup)
            <a href="{{ asset('storage/' . $vendor->file_siup) }}" target="_blank" class="btn btn-dark btn-sm">
                <i class="fa fa-file"></i> Lihat Dokumen
            </a>
        @else
            -
        @endif
    </td>
</tr>

<tr>
    <th>Dokumen ISO</th>
    <td>
        @if($vendor->file_iso)
            <a href="{{ asset('storage/' . $vendor->file_iso) }}" target="_blank" class="btn btn-dark btn-sm">
                <i class="fa fa-file"></i> Lihat Dokumen
            </a>
        @else
            -
        @endif
    </td>
</tr>

<tr>
    <th>Dokumen SKF</th>
    <td>
        @if($vendor->file_skf)
            <a href="{{ asset('storage/' . $vendor->file_skf) }}" target="_blank" class="btn btn-dark btn-sm">
                <i class="fa fa-file"></i> Lihat Dokumen
            </a>
        @else
            -
        @endif
    </td>
</tr>


        {{-- PIC 1 --}}
        <tr><th colspan="2" class="bg-dark text-white">PIC 1</th></tr>
        <tr><th>Nama Lengkap</th><td>{{ $vendor->nama_lengkap1 ?? '-' }}</td></tr>
        <tr><th>Jabatan</th><td>{{ $vendor->jabatan1 ?? '-' }}</td></tr>
        <tr><th>Email</th><td>{{ $vendor->email1 ?? '-' }}</td></tr>
        <tr><th>Telepon</th><td>{{ $vendor->telepon1 ?? '-' }}</td></tr>

        {{-- PIC 2 --}}
        <tr><th colspan="2" class="bg-dark text-white">PIC 2</th></tr>
        <tr><th>Nama Lengkap</th><td>{{ $vendor->nama_lengkap2 ?? '-' }}</td></tr>
        <tr><th>Jabatan</th><td>{{ $vendor->jabatan2 ?? '-' }}</td></tr>
        <tr><th>Email</th><td>{{ $vendor->email2 ?? '-' }}</td></tr>
        <tr><th>Telepon</th><td>{{ $vendor->telepon2 ?? '-' }}</td></tr>

        {{-- User --}}
        <tr><th>Dibuat Oleh (User ID)</th><td>{{ $vendor->id_user ?? '-' }}</td></tr>
        <tr><th>Tanggal Registrasi</th><td>{{ $vendor->created_at ? $vendor->created_at->format('d-m-Y') : '-' }}</td></tr>

    </table>

</div>
@endsection
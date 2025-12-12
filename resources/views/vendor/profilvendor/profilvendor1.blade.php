<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Vendor || PT.INKA Multi Solusi E-Procurement</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/vendor/profilvendor.css">
    <link rel="stylesheet" href="css/sidebarvendor.css">
</head>

@extends('vendor.layout.sidebarvendor')

@section('content')
<div class="main-content">
    <h1>PROFILE VENDOR</h1>
        <div class="main-content">
            <div class="container-profil-responsive">
                <div class="profil-container">
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profil-info">
                        <h2>Profil</h2>
                        <div class="profil-form">
                            <div class="form-group">
                                <label for="nama-perusahaan">Nama Perusahaan</label>
                                <input type="text" id="nama-perusahaan" class="form-control" readonly value="PT. Angkasa Jaya Kediri">
                            </div>
                            <div class="form-group">
                                <label for="npwp">No. NPWP Perusahaan</label>
                                <input type="text" id="npwp" class="form-control" readonly value="143-2132-1231-534-21">
                            </div>
                            <div class="form-group">
                                <label for="fax">No. Fax Perusahaan</label>
                                <input type="text" id="fax" class="form-control" readonly value="+1 (555) 123-4567">
                            </div>
                            <div class="form-group">
                                <label for="telepon">No. Telepon Perusahaan</label>
                                <input type="text" id="telepon" class="form-control" readonly value="089950069584">
                            </div>
                            <div class="form-group">
                                <label for="email">E-Mail Perusahaan</label>
                                <input type="text" id="email" class="form-control" readonly value="angkasakedirijaya@gmail.com">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Perusahaan</label>
                                <input type="text" id="alamat" class="form-control" readonly value="Jln. Manggis No.12 Kab. Kediri, Jawa Timur, Indonesia">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kontak-container">
                    <div class="kontak-info">
                        <h2>Kontak Pribadi</h2>
                        <div class="kontak-form">
                            <div class="form-group">
                                <label for="nama-lengkap">Nama Lengkap</label>
                                <input type="text" id="nama-lengkap" class="form-control" readonly value="Syaifudin Nur Ali">
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" id="jabatan" class="form-control" readonly value="Direktur PT. Angkasa Jaya Kediri">
                            </div>
                            <div class="form-group">
                                <label for="email-pribadi">E-Mail Pribadi</label>
                                <input type="text" id="email-pribadi" class="form-control" readonly value="syaifudinnurali@gmail.com">
                            </div>
                            <div class="form-group">
                                <label for="telepon-pribadi">No. Telepon Pribadi</label>
                                <input type="text" id="telepon-pribadi" class="form-control" readonly value="083948827367">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
            var detailButtons = document.querySelectorAll('.lihat-detail');
            detailButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    window.location.href = 'detailpenawaran';
                });
            });
    </script>
@endsection
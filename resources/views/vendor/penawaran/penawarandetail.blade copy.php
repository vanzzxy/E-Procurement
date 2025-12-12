<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penawaran Vendor || PT.INKA Multi Solusi E-Procurement</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/vendor/penawarandetail.css">
    <link rel="stylesheet" href="css/sidebarvendor.css">
</head>

@extends('vendor.layout.sidebarvendor')

@section('content')
        <div class="main-content">
            <h1>DETAIL PENAWARAN</h1>
            <div class="underline"></div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="card-content">
                    <h4>Justifikasi & Kontrak</h4>
                    <p>Pengirim : PT.INKA Multi Solusi<br>
                       Nomor Surat : XXXXXX<br>
                    <h4> Deskripsi :</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris condimentum enim in velit lacinia hendrerit. 
                        Nullam convallis eros eu malesuada suscipit. Phasellus id quam non magna fringilla lacinia. 
                        Sed eu neque semper, scelerisque ligula ut, suscipit ligula. Aliquam erat volutpat. 
                        Vestibulum vehicula tortor nec urna faucibus, a posuere augue congue. Nulla vel odio sed magna dignissim feugiat. 
                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis venenatis bibendum libero, eu vestibulum erat consectetur vel. Proin interdum interdum risus, nec lobortis augue molestie sit amet. In hac habitasse platea dictumst. Nunc scelerisque lorem in libero faucibus, nec rutrum nisi ultricies. Nulla ut eros vitae mi tristique blandit. Nam in massa at lectus accumsan convallis. Cras suscipit nisi risus, eget molestie justo fermentum sit amet. 
                        Sed rutrum, odio ac pellentesque iaculis, ex dolor lobortis libero, ac aliquam dui nunc ac dui.</p>
                </div>
                <div class="card-actions">
                <a href="#" class="btn secondary" id="upload-button"><i class="fas fa-reply"></i>Balas</a>
                </div>
            </div>
        </div>

   <!-- Dialog untuk Upload -->
        <div id="upload-dialog" class="dialog">
            <div class="dialog-content">
                <span class="close" onclick="closeUploadDialog()">&times;</span>
                <h2>Unggah Dokumen Negosiasi</h2>
                <div id="drop-zone" class="drop-zone">
                    <i class="fas fa-upload"></i>
                    <p>Seret dan letakkan file di sini <br> atau</p>
                    <button class="btn browse-btn">Jelajahi File</button>
                    <input type="file" id="file-upload" name="file-upload" accept=".pdf,.docx,.xlsx" required>
                </div>
                <form id="upload-form">
                    <label for="file-name">Nomor Surat</label>
                    <input type="text" id="file-name" name="file-name" placeholder="Input Nomor Surat" required>
                    
                    <label for="file-type">Jenis Surat</label>
                    <select id="file-type" name="file-type" required>
                        <option value="" disabled selected>Pilih Jenis Surat</option>
                        <option value="pdf">Surat Penawaran Harga</option>
                        <option value="pdf">Negosiasi Penawaran</option>
                    </select>
                    
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" placeholder="Masukkan Deskripsi" rows="3"></textarea>

                    <div class="form-actions">
                        <button type="button" class="btn secondary" onclick="closeUploadDialog()">Batal</button>
                        <button type="submit" class="btn primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>



    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        document.getElementById('upload-button').addEventListener('click', openUploadDialog);

        function openUploadDialog() {
            document.getElementById('upload-dialog').style.display = 'flex'; // Menggunakan 'flex' untuk memusatkan dialog
        }

        function closeUploadDialog() {
            document.getElementById('upload-dialog').style.display = 'none';
        }
        
        // Menangani drag and drop
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-upload');

        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.classList.add('dragging');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragging');
        });

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.classList.remove('dragging');
            fileInput.files = event.dataTransfer.files;
        });


        
        document.getElementById('file-upload').addEventListener('change', function() {
            document.querySelector('.drop-zone p').textContent = this.files[0].name;
        });

        document.querySelector('.drop-zone').addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        document.querySelector('.drop-zone').addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });

        document.querySelector('.drop-zone').addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            var files = e.dataTransfer.files;
            document.querySelector('.drop-zone p').textContent = files[0].name;
            document.getElementById('file-upload').files = files;
        });

        function closeUploadDialog() {
            document.getElementById('upload-dialog').style.display = 'none';
        }

    </script>
@endsection
<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorRiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/vendor/json', [VendorController::class, 'json'])->name('vendor.json');
Route::get('/admin/vendor/ajax', [VendorController::class, 'ajaxVendor'])->name('vendor.ajax');

// ======================================================================================================================================================
// ===== HALAMAN UTAMA ==== ===== HALAMAN UTAMA ==== ===== HALAMAN UTAMA ==== ===== HALAMAN UTAMA ==== ===== HALAMAN UTAMA ==== ===== HALAMAN UTAMA ====
// ======================================================================================================================================================

Route::get('/halamanlogin', function () {
    return view('webutama/halamanlogin');
});
Route::get('halamanlogin', [HomeController::class, 'halamanlogin']);

Route::get('/registrasi', function () {
    return view('webutama/registrasi');
});
Route::get('registrasi', [HomeController::class, 'registrasi']);

Route::get('/', function () {
    return view('webutama/utamaberanda');
});
Route::get('beranda', [HomeController::class, 'beranda']);

Route::get('/syarat', function () {
    return view('webutama/utamasyarat');
});
Route::get('syarat', [HomeController::class, 'syarat']);

Route::get('/tentang', function () {
    return view('webutama/utamatentang');
});
Route::get('tentang', [HomeController::class, 'tentang']);

// ======================================================================================================================================================
// ===== REGISTRASI, LOGIN, LOG OUT ==== ==== REGISTRASI, LOGIN, LOG OUT ==== ==== REGISTRASI, LOGIN, LOG OUT ==== ==== REGISTRASI, LOGIN, LOG OUT ======
// ======================================================================================================================================================

Route::get('/registrasi', [VendorController::class, 'registrasi'])->name('registrasi');
Route::post('/vendor/registrasi', [VendorController::class, 'store'])->name('vendor.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// ======================================================================================================================================================
// ====== ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN =====
// ======================================================================================================================================================

// ==================== BERANDA ADMIN ====================

Route::get('/admin/beranda', [App\Http\Controllers\AdminBerandaController::class, 'index'])
    ->name('admin.beranda');

// ==================== DAFTAR VENDOR ====================

Route::get('/daftarvendor', [VendorController::class, 'index'])->name('vendor.index');
Route::get('/detaildatavendor/{id}', [VendorController::class, 'detail'])->name('vendor.detail');

// // ==================== DAFTAR CALON REKANAN ====================

use App\Http\Controllers\DcrController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin/dcr', [DcrController::class, 'index'])->name('dcr.index');
    Route::get('/admin/dcr/create', [DcrController::class, 'create'])->name('dcr.create');
    Route::post('/admin/dcr/store', [DcrController::class, 'store'])->name('dcr.store');
    Route::post('/admin/dcr/store-ajax', [DcrController::class, 'storeAjax'])->name('dcr.store.ajax');

    Route::get('/admin/dcr/{id}', [DcrController::class, 'show'])->name('dcr.show');
    Route::delete('/admin/dcr/{id}', [App\Http\Controllers\DcrController::class, 'destroy'])->name('dcr.destroy');
    Route::resource('dcr', DcrController::class)->middleware('auth');
    Route::get('admin/vendor/{id}/detail', [VendorController::class, 'show'])->name('admin.detaildatavendor');
    Route::get('/admin/dcr/data', [DcrController::class, 'data'])->name('dcr.data');

});

Route::post('/admin/vendor/upload-surat', [App\Http\Controllers\Admin\VendorController::class, 'uploadSurat'])
    ->name('admin.vendor.uploadSurat');

// ==================== DATA MASTER ====================
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterKlasifikasiController;
use App\Http\Controllers\MasterStatusController;

// MASTERBARANG
Route::prefix('admin')->group(function () {
    return view('admin/datamaster/masterbarang/masterbarang');
})->name('masterbarang');
Route::get('/masterbarang', [MasterBarangController::class, 'index'])->name('masterbarang.index');
Route::post('/masterbarang/store', [MasterBarangController::class, 'store'])->name('masterbarang.store');
Route::put('/masterbarang/update/{id}', [MasterBarangController::class, 'update'])->name('masterbarang.update');
Route::delete('/masterbarang/delete/{id}', [MasterBarangController::class, 'destroy'])->name('masterbarang.delete');

// MASTERKLASIFIKASI
Route::get('/masterklasifikasi', [MasterKlasifikasiController::class, 'index'])->name('masterklasifikasi');
Route::post('/masterklasifikasi/store', [MasterKlasifikasiController::class, 'store'])->name('masterklasifikasi.store');
Route::post('/masterklasifikasi/update/{id}', [MasterKlasifikasiController::class, 'update'])->name('masterklasifikasi.update');
Route::delete('/masterklasifikasi/delete/{id}', [MasterKlasifikasiController::class, 'destroy'])
    ->name('masterklasifikasi.delete');
Route::put('/masterklasifikasi/update', [MasterKlasifikasiController::class, 'update'])
    ->name('masterklasifikasi.update');

// MASTERSTATUS
Route::get('/masterstatus', [MasterStatusController::class, 'index'])->name('masterstatus.index');
Route::post('/masterstatus/store', [MasterStatusController::class, 'store'])->name('masterstatus.store');
Route::put('/masterstatus/update', [MasterStatusController::class, 'update'])->name('masterstatus.update');
Route::delete('/masterstatus/delete/{id}', [MasterStatusController::class, 'delete'])->name('masterstatus.delete');

// ==================== INBOX ADMIN ====================
use App\Http\Controllers\InboxAdminController;

Route::middleware(['auth'])->group(function() {

    Route::get('/admin/inbox', [InboxAdminController::class, 'index'])
        ->name('admin.inbox');

    Route::get('/admin/inbox/detail/{id}', [InboxAdminController::class, 'showDetail'])
        ->name('admin.inbox.detail');

    Route::get('/admin/inbox/download/{id}', [InboxAdminController::class, 'download'])
        ->name('admin.inbox.download');

    Route::delete('/admin/inbox/{id}', [InboxAdminController::class, 'destroy'])
        ->name('admin.inbox.delete');

    Route::get('/admin/inbox/list-ajax', [InboxAdminController::class, 'listAjax'])
        ->name('admin.inbox.list.ajax');

    // ⭐ ROUTE YANG HILANG (menyebabkan error)
    Route::post('/admin/inbox/balas-ajax', [InboxAdminController::class, 'balasAjax'])
        ->name('admin.inbox.balas.ajax');

    Route::get('/admin/inbox/filter', [InboxAdminController::class, 'filterAjax'])
        ->name('admin.inbox.filter');

});

// ==================== KONTRAK ADMIN ====================

// ==================== BUAT KONTRAK

Route::get('/vendor/{id}/kategori', [VendorController::class, 'getKategori']);

use App\Http\Controllers\BuatKontrakController;

Route::prefix('buatkontrak')->group(function () {

    // Index & Create
    Route::get('/', [BuatKontrakController::class, 'index'])->name('buatkontrak.index');
    Route::get('/create', [BuatKontrakController::class, 'create'])->name('buatkontrak.create');

    // Store
    Route::post('/store', [BuatKontrakController::class, 'store'])->name('buatkontrak.store');

    // Detail kontrak
    Route::get('/{id}/detail', [BuatKontrakController::class, 'detail'])->name('buatkontrak.detail');

    // Edit kontrak
    Route::get('/{id}/edit', [BuatKontrakController::class, 'edit'])->name('buatkontrak.edit');

    // Update kontrak
    Route::put('/{id}', [BuatKontrakController::class, 'update'])->name('buatkontrak.update');

    // Upload file kontrak
    Route::post('/{id}/upload', [BuatKontrakController::class, 'upload'])->name('buatkontrak.upload');

    // Tambah Barang
    Route::post('/{id}/barang/add', [BuatKontrakController::class, 'addBarang'])->name('buatkontrak.barang.add');

    // Update Barang
    Route::post(
        '/{id}/barang/{barangId}/update',
        [BuatKontrakController::class, 'updateBarang']
    )->name('buatkontrak.barang.update');

    // Delete Barang
    Route::delete(
        '/{id}/barang/{barangId}',
        [BuatKontrakController::class, 'destroyBarang']
    )->name('buatkontrak.barang.delete');

    // Delete Kontrak
    Route::delete('/{id}', [BuatKontrakController::class, 'destroy'])->name('buatkontrak.destroy');

    // Get Barang by kategori
    Route::get('/barang/{kategori}', [BuatKontrakController::class, 'getBarangByKategori'])
        ->name('buatkontrak.barang');
});

// ==================== DATA KONTRAK

use App\Http\Controllers\DataKontrakController;

Route::prefix('datakontrak')->group(function () {

    Route::get('/', [DataKontrakController::class, 'index'])
        ->name('datakontrak.index');

    Route::delete('/{id}/delete-upload', [DataKontrakController::class, 'deleteUpload'])
        ->name('datakontrak.delete_upload');

    Route::post('/kirim', [DataKontrakController::class, 'kirim'])
        ->name('datakontrak.kirim');

    Route::put('/update-status/{id}', [DataKontrakController::class, 'updateStatus'])
        ->name('datakontrak.updateStatus');

    Route::get('/status-badge/{status}', function ($status) {
        return view('components.status_badge', ['status' => $status])->render();
    });

});

// ==================== PENGIRIMAN ADMIN ====================

use App\Http\Controllers\AdminPengirimanController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Halaman daftar pengiriman
    Route::get('/pengiriman', [AdminPengirimanController::class, 'index'])
        ->name('pengiriman.index');

    // Detail pengiriman (versi 1)
    Route::get('/pengiriman/detail/{id}', [AdminPengirimanController::class, 'show'])
        ->name('pengiriman.detailModal');

    // Update status diterima
    Route::post('/pengiriman/diterima/{id}', [AdminPengirimanController::class, 'diterima'])
        ->name('pengiriman.diterima');

    // Detail pengiriman admin (versi 2)
    Route::get('/pengirimanadmin/detail/{id}', [AdminPengirimanController::class, 'detailModal'])
        ->name('pengirimanadmin.detailModal');

    Route::get('admin/status-badge/{status}', function ($status) {
        return view('admin.layout.status_badge', ['status' => $status])->render();
    });

});

// ==================== PROFIL ADMIN ====================

Route::middleware(['auth'])->group(function () {

    // Profil Admin
    Route::get('/profiladmin', [AdminProfileController::class, 'index'])->name('profiladmin');
    Route::post('/profiladmin/update', [AdminProfileController::class, 'updateProfile'])->name('profiladmin.update');
    Route::delete('/profiladmin/delete/{id}', [AdminProfileController::class, 'delete'])
        ->name('profiladmin.delete');

    // Tambah admin (modal)
    Route::post('/profiladmin/add-admin', [AdminProfileController::class, 'addAdmin'])->name('profiladmin.addAdmin');

    // List admin (superadmin only)
    Route::middleware(['can:manage-admin'])->group(function () {
        Route::get('/admin/list', [AdminProfileController::class, 'list'])->name('admin.list');
        Route::post('/admin/add', [AdminProfileController::class, 'store'])->name('admin.add');
        Route::put('/admin/update/{id}', [AdminProfileController::class, 'update'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminProfileController::class, 'delete'])->name('admin.delete');
    });
});

// ==================== RIWAYAT ADMIN ====================

use App\Http\Controllers\AdminRiwayatController;

Route::middleware(['auth'])->group(function () {
    // Riwayat Masuk
    Route::get('/admin/riwayat/masuk', [AdminRiwayatController::class, 'index'])
        ->name('admin.riwayatmasuk');

    // Riwayat Keluar
    Route::get('/admin/riwayat/keluar', [AdminRiwayatController::class, 'keluar'])
        ->name('admin.riwayatkeluar');

    // Detail Kontrak tetap di AdminRiwayatController
    Route::get('/admin/datakontrak/{id}', [AdminRiwayatController::class, 'detail'])
        ->name('admin.riwayatadmin.detailkontrak');
});



// ======================================================================================================================================================
// ===== VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR VENDOR ====
// ======================================================================================================================================================

// ==================== BERANDA VENDOR ====================
use App\Http\Controllers\VendorBerandaController;

Route::get('/berandavendor', [VendorBerandaController::class, 'index'])
    ->name('vendor.beranda')
    ->middleware('auth');

// ==================== PENAWARAN VENDOR ====================
use App\Http\Controllers\VendorPenawaranBalasController;
use App\Http\Controllers\VendorPenawaranController;

Route::get('/vendor/penawaran', [VendorPenawaranController::class, 'index'])
    ->name('vendor.penawaran');
Route::get('/vendor/penawaran/download/{id}', [VendorPenawaranController::class, 'download'])
    ->name('vendor.penawaran.download');
Route::get('/vendor/penawaran/detail/{id}', [VendorPenawaranController::class, 'detail'])
    ->name('vendor.penawaran.detail');

Route::post('/vendor/penawaran/balas/ajax', [VendorPenawaranBalasController::class, 'storeAjax'])
    ->name('vendor.penawaran.balas.ajax');
Route::delete('/vendor/penawaran/{id}', [VendorPenawaranBalasController::class, 'destroy'])
    ->name('vendor.penawaran.delete');
Route::get('/vendor/penawaran/download/{id}', [VendorPenawaranBalasController::class, 'download'])
    ->name('vendor.penawaran.download');

// ==================== INBOX VENDOR ====================

use App\Http\Controllers\InboxVendorController;

Route::prefix('vendor')->group(function () {
    Route::get('/inboxvendor', [InboxVendorController::class, 'index'])->name('vendor.inbox');
    
    Route::get('/inboxvendor/detail/{id}', [InboxVendorController::class, 'detail'])->name('vendor.inbox.detail');
    
    Route::get('/inboxvendor/download/{id}', [InboxVendorController::class, 'download'])
        ->name('vendor.inbox.download');
    
        Route::delete('/inboxvendor/delete/{id}', [InboxVendorController::class, 'destroy'])
        ->name('vendor.inbox.delete');
});

// ==================== DOKUMEN VENDOR ====================

Route::prefix('admin')->group(function () {
    // Detail data vendor
    Route::get('vendor/{id}/detail', [VendorController::class, 'show'])->name('admin.detaildatavendor');
    // Upload surat vendor
    Route::post('vendor/upload-surat', [VendorController::class, 'uploadSurat'])->name('admin.vendor.uploadSurat');
});

// ==================== KONTRAK VENDOR ====================

use App\Http\Controllers\VendorKontrakController;

Route::get('/vendor/kontrak', [VendorKontrakController::class, 'index'])->name('vendor.kontrak');
Route::get('/vendor/kontrak/download/{id}', [VendorKontrakController::class, 'download'])->name('vendor.kontrak.download');
Route::get('/vendor/kontrak/detail/{id}', [VendorKontrakController::class, 'detail'])->name('vendor.kontrak.detail');
Route::get('/vendor/kontrak/edit/{id}', [VendorKontrakController::class, 'edit'])->name('vendor.kontrak.edit');
Route::put('/vendor/kontrak/update/{id}', [VendorKontrakController::class, 'update'])
    ->name('vendor.kontrak.update');

// ==================== PENGIRIMAN VENDOR ====================

use App\Http\Controllers\VendorPengirimanController;

Route::middleware(['auth'])->group(function () {

    // Halaman index harus di atas
    Route::get('/vendor/pengiriman', [VendorPengirimanController::class, 'index'])
        ->name('vendor.pengiriman');

    // Halaman tambah spesifik sebelum {id}
    Route::get('/vendor/pengiriman/tambah', [VendorPengirimanController::class, 'create'])
        ->name('vendor.pengiriman.tambah');

    // AJAX get barang spesifik sebelum {id}
    Route::get('/vendor/pengiriman/barang/{po}', [VendorPengirimanController::class, 'getBarang'])
        ->name('vendor.pengiriman.getBarang');

    // Action selesai
    Route::post('/vendor/pengiriman/selesai/{id}', [VendorPengirimanController::class, 'selesai'])
        ->name('vendor.pengiriman.selesai');

    Route::delete('/pengiriman/hapus/{id}', [VendorPengirimanController::class, 'destroy'])
        ->name('vendor.pengiriman.hapus');

    // Store pengiriman
    Route::post('/vendor/pengiriman/store', [VendorPengirimanController::class, 'store'])
        ->name('vendor.pengiriman.store');

    // Route show harus **paling bawah** karena menangkap /{id} dinamis
    Route::get('/vendor/pengiriman/{id}/detail', [VendorPengirimanController::class, 'detailModal'])
        ->name('vendor.pengiriman.detailModal');

});

// ==================== PROFIL VENDOR ====================

use App\Http\Controllers\VendorProfileController;

// PROFIL VENDOR
Route::get('/vendor/profile/{id}', [VendorProfileController::class, 'index'])
    ->name('vendor.profile');

Route::post('/vendor/update/{id}', [VendorProfileController::class, 'updateProfile'])
    ->name('vendor.updateProfile');

Route::post('/vendor/update-photo/{id}', [VendorProfileController::class, 'updatePhoto'])
    ->name('vendor.updatePhoto');

// =====================
// DOKUMEN VENDOR
// =====================
Route::post('/vendor/dokumen/upload', [VendorProfileController::class, 'uploadDokumen'])
    ->name('vendor.uploadDokumen');

Route::get('/vendor/dokumen/download/{type}', [VendorProfileController::class, 'downloadDokumen'])
    ->name('vendor.downloadDokumen');

Route::delete('/vendor/dokumen/delete/{type}', [VendorProfileController::class, 'deleteDokumen'])
    ->name('vendor.deleteDokumen');



// ==================== RIWAYAT VENDOR ====================
Route::middleware(['auth'])->group(function () {

    Route::get('/vendor/riwayat/keluar', [VendorRiwayatController::class, 'index'])
        ->name('vendor.riwayatkeluar');

    Route::get('/vendor/riwayat/keluar/ajax-suratadmin', [VendorRiwayatController::class, 'ajaxSuratAdmin'])
        ->name('vendor.riwayat.ajax.suratadmin');

    Route::get('/vendor/riwayat/keluar/ajax-pengiriman', [VendorRiwayatController::class, 'ajaxPengiriman'])
        ->name('vendor.riwayat.ajax.pengiriman');

        // Halaman Riwayat Surat Masuk
    Route::get('/vendor/riwayat/masuk', [VendorRiwayatController::class, 'riwayatMasuk'])
        ->name('vendor.riwayatmasuk');

    Route::get('/vendor/datakontrak/{id}/detail', [VendorRiwayatController::class, 'detailDatakontrak'])
    ->name('vendor.datakontrak.detail');

});

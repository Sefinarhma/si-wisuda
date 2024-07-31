<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\table;

/**
 * ! Jangan ubah route yang ada dalam group ini
 * */
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'checkToken')->name('check');
        Route::get('/logout', 'logout')->name('logout'); // gunakan untuk logout
        Route::get('/roles', 'changeUserRole')->middleware('auth.token');
    });

/**
 * ! Jadikan route di bawah sebagai halaman utama dari web
 * ! harap tidak mengubah nilai pada name();
 */
Route::middleware('auth.token')
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

/**
 * * Buat route-route baru di bawah ini
 * * Pastikan untuk selalu menggunakan middleware('auth.token')
 * * middleware tersebut digunakan untuk verifikasi access pengguna dengan web
 *
 * * Bisa juga ditambahkan dengan middleware lainnya.
 * * Berikut adalah beberapa middleware lain yang telah tersedia,
 * * dapat digunakan untuk mengatur akses route berdasarkan role user
 *
 * 1.) auth.admin -> biasa digunakan untuk akses route untuk manage user lain
 * 2.) auth.mahasiswa -> akses route untuk user dengan role mahasiswa
 * 3.) auth.dosen -> akses route untuk user dengan role dosen
 * 4.) auth.developer -> akses route untuk user developer
 *
 * ? contoh penggunaan: middleware(['auth.token', 'auth.mahasiswa'])
 */

// Route untuk role: mahasiswa
Route::get('/pendaftaran', [MahasiswaController::class, 'pendaftaran'])->middleware(['auth.token', 'auth.mahasiswa'])->name('pendaftaran.index');
// Add the name to the '/detail' route
Route::post('/pendaftaran', [MahasiswaController::class, 'store'])->middleware(['auth.token', 'auth.mahasiswa'])->name('pendaftaran.store');
Route::post('/kirim/edit/{pengajuan_id}', [MahasiswaController::class, 'update'])->middleware(['auth.token', 'auth.mahasiswa']);
Route::get('/detail', [MahasiswaController::class, 'detail'])->middleware(['auth.token', 'auth.mahasiswa'])->name('pendaftaran.detail');
Route::get('/edit/pengajuan/mahsiswa/{pengajuan_id}', [MahasiswaController::class, 'editDetail'])->middleware(['auth.token', 'auth.mahasiswa']);



// Route untuk role: admin
Route::get('/tabel', [AdminController::class, 'tabel'])->middleware(['auth.token', 'auth.admin']);
Route::get('/rekap', [AdminController::class, 'rekap'])->middleware(['auth.token', 'auth.admin']);
Route::post('/rekap/{tahun}', [AdminController::class, 'rekapByTahun'])->middleware(['auth.token', 'auth.admin']);
Route::get('/jadwal', [AdminController::class, 'jadwal'])->middleware(['auth.token', 'auth.admin']);
Route::post('/add/jadwal', [AdminController::class, 'tambahjadwal'])->middleware(['auth.token', 'auth.admin']);
Route::post('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
Route::post('/verifikasi/mahasiswa', [AdminController::class, 'verifikasiMahasiswa'])->name('verifikasiMahasiswa');
Route::post('/hapus/jadwal', [AdminController::class, 'hapusjadwal'])->middleware(['auth.token', 'auth.admin']);
Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('export.excel')->middleware(['auth.token', 'auth.admin']);



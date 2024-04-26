<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\BukuController;
use App\Http\Controllers\Dashboard\KategoriController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\PetugasController;
use App\Http\Controllers\LandingPage\LandingPageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('add-password-for-google-user', [LandingPageController::class, 'addPassword'])->name('addPassword');
route::post('add-password-for-google-user', [LandingPageController::class, 'addPasswordSubmit'])->name('addPasswordSubmit');
route::get('login-google', [GoogleController::class, 'googleLogin'])->name('googleLogin');
route::get('login-google-profile', [GoogleController::class, 'googleConnect'])->name('googleConnect');
route::get('google-callback', [GoogleController::class, 'googleCallback'])->name('googleCallback');
Route::get('/reload-captcha', [RegisterController::class, 'reloadCaptcha'])->name('reloadCap');

route::group(['middleware' => 'GoogleEmail'], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('landingPage');
    route::get('buku', [LandingPageController::class, 'buku'])->name('bukuPage');
    route::get('buku-detail/{slug}', [LandingPageController::class, 'detailBuku'])->name('detailBuku');
    Auth::routes();

    route::group(['middleware' => 'role:user'], function () {
        route::get('profil-user', [LandingPageController::class, 'profileUser'])->name('profilUser');
        route::post('update-profile-user', [LandingPageController::class, 'updateProfileUser'])->name('updateProfileUser');
        route::post('favorit', [LandingPageController::class, 'favorit'])->name('favorit');
        route::post('kirim-komentar', [LandingPageController::class, 'kirimKomentar'])->name('kirimKomentar');
        route::get('baca-buku/{id}', [LandingPageController::class, 'bacaBuku'])->name('BacaBuku');
        route::post('daftar-member', [LandingPageController::class, 'daftarMember'])->name('dafatarMember');
        route::get('all-favorit', [LandingPageController::class, 'favoritList'])->name('favoritList');
    });
});


route::group(['middleware' => ['role:admin|petugas']], function () {
    route::prefix('dashboard/')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        // Managemen Kategori URL
        route::get('kategori', [KategoriController::class, 'index'])->name('managemenKategori');
        route::post('tambah-kategori', [KategoriController::class, 'store'])->name('tambahKategori');
        route::get('edit-kategori/{id}', [KategoriController::class, 'show'])->name('editKategori');
        route::post('update-kategori/{id}', [KategoriController::class, 'update'])->name('updateKategori');
        route::post('delete-kategori', [KategoriController::class, 'destroy'])->name('deleteKategori');

        // Managemen Buku
        route::get('buku', [BukuController::class, 'index'])->name('managemenBuku');
        route::post('tambah-buku', [BukuController::class, 'store'])->name('tambahBuku');
        route::get('edit-buku/{id}', [BukuController::class, 'edit'])->name('editBuku');
        route::post('update-buku/{id}', [BukuController::class, 'update'])->name('updateBuku');
        route::post('delete-buku', [BukuController::class, 'destroy'])->name('deleteBuku');
        route::get('export-excel', [BukuController::class, 'excel'])->name('exportExcel');
        route::get('log-Buku', [BukuController::class, 'logBuku'])->name('logBuku');

        // Laporan
        route::get('laporan', [LaporanController::class, 'index'])->name('laporan');

        route::middleware('role:admin')->group(function () {
            // Managemen Petugas
            route::get('petugas', [PetugasController::class, 'index'])->name('managemenPetugas');
            route::post('tambah-petugas', [PetugasController::class, 'store'])->name('tambahPetugas');
            route::get('edit-petugas/{id}', [PetugasController::class, 'edit'])->name('editPetugas');
            route::post('update-petugas/{id}', [PetugasController::class, 'update'])->name('updatePetugas');
            route::post('hapus-petugas', [PetugasController::class, 'destroy'])->name('hapusPetugas');
        });
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\DaftarUserController;
use App\Http\Controllers\DaftarPakarController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UbahPasswordController;


//tampilan user
Route::get('/', function () {return view('home.index');})->name('home.index');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/diagnosa', [DiagnosaController::class, 'form'])->name('diagnosa.form');
});
//tampilan admin
   Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


//menampilkan login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/registration', [AuthController::class, 'registration'])->name('registration');
    Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('password/reset/{token}', [UbahPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [UbahPasswordController::class, 'reset'])->name('password.update');
});
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

//profile user
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/set-profile', [ProfileController::class, 'setProfile'])->name('setProfile');

//menambahkan user
Route::get('/admin/daftar-user', [DaftarUserController::class, 'index'])->name('DaftarUser.index');
Route::delete('/user/{id}', [DaftarUserController::class, 'destroy'])->name('user.destroy');
// Route::get('/user/create', [DaftarUserController::class, 'create'])->name('user.create');
// Route::post('/users', [DaftarUserController::class, 'store'])->name('users.store');

//menambahkan pakar
Route::get('/admin/daftar-pakar', [DaftarPakarController::class, 'index'])->name('DaftarPakar.index');
Route::post('/admin/daftar-pakar', [DaftarPakarController::class, 'store'])->name('pakar.store');
//hapus dan edit
Route::delete('/admin/pakar/{id}', [DaftarPakarController::class, 'destroy'])->name('pakar.destroy');
Route::put('/admin/pakar/{id}', [DaftarPakarController::class, 'update'])->name('pakar.update');

//pertanyaan
Route::get('/admin/pertanyaan', [PertanyaanController::class, 'index'])->name('Pertanyaan.index');
Route::post('/admin/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
//hapus dan edit
Route::delete('/admin/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');
Route::put('/admin/pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');

//gejala
Route::get('/admin/gejala', [GejalaController::class, 'index'])->name('Gejala.index');
Route::post('/admin/gejala', [GejalaController::class, 'store'])->name('gejala.store');
//hapus dan edit
Route::delete('/admin/gejala/{id_gejala}', [GejalaController::class, 'destroy'])->name('gejala.destroy');
Route::put('/admin/gejala/{id_gejala}', [GejalaController::class, 'update'])->name('gejala.update');

//Aturan
Route::get('/admin/daftar-aturan', [AturanController::class, 'index'])->name('DaftarAturan.index');
Route::post('/admin/aturan', [AturanController::class, 'store'])->name('aturan.store');
//hapus dan edit
Route::delete('/admin/aturan/{id_rule}', [AturanController::class, 'destroy'])->name('aturan.destroy');
Route::put('/admin/aturan/{id_rule}', [AturanController::class, 'update'])->name('aturan.update');

//riwayat konsultasi
Route::get('/admin/konsultasi', [KonsultasiController::class, 'riwayatDiagnosa'])->name('Konsultasi.index');
Route::get('/admin/konsultasi/{id_user}/detail', [KonsultasiController::class, 'detailPdf'])->name('konsultasi.detail');
Route::get('/user/riwayat-konsultasi', [KonsultasiController::class, 'riwayatUser'])->name('user.riwayat');
Route::get('/user/hasil-diagnosa/{id_user}', [KonsultasiController::class, 'hasilPdf'])->name('diagnosa.hasilPdf');

//menampilkan pertanyaan di halaman diagnosa
Route::post('/diagnosa/submit', [DiagnosaController::class, 'submitDiagnosa'])->name('diagnosa.submit');
Route::get('/diagnosa', [DiagnosaController::class, 'formDiagnosa'])->name('diagnosa.form');
// // Route::get('/diagnosa/show', [DiagnosaController::class, 'show'])->name('diagnosa.show');
Route::post('/hasil', [DiagnosaController::class, 'proses'])->name('hasil');
Route::get('/diagnosa/cetak-pdf/{id_user}' , [DiagnosaController::class, 'cetakPdf'])->name('diagnosa.cetakPdf');
Route::get('/pilih-profil/{jenis_kelamin}', [DiagnosaController::class, 'pilihProfil'])->name('pilih.profil');

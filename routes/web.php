<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

route::middleware('isLogin')->group(function() {
// login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProses'])->name('loginProses');
});

// logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

route::middleware('checkLogin')->group(function() {

// dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('tugas', [TugasController::class, 'index'])->name('tugas');
Route::get('tugas/pdf', [TugasController::class, 'pdf'])->name('tugasPdf');

route::middleware('isAdmin')->group(function() {
    // user
Route::get('user', [UserController::class, 'index'])->name('user');
Route::get('user/create', [UserController::class, 'create'])->name('userCreate');
Route::post('user/store', [UserController::class, 'store'])->name('userStore');
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('userEdit');
Route::post('user/update/{id}', [UserController::class, 'update'])->name('userUpdate');
Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('userDestroy');
Route::get('user/excel', [UserController::class, 'excel'])->name('userExcel');
Route::get('user/pdf', [UserController::class, 'pdf'])->name('userPdf');

// tugas
Route::get('tugas/create', [TugasController::class, 'create'])->name('tugasCreate');
Route::post('tugas/store', [TugasController::class, 'store'])->name('tugasStore');
Route::get('tugas/edit/{id}', [TugasController::class, 'edit'])->name('tugasEdit');
Route::post('tugas/update/{id}', [TugasController::class, 'update'])->name('tugasUpdate');
Route::delete('tugas/destroy/{id}', [TugasController::class, 'destroy'])->name('tugasDestroy');
Route::get('tugas/excel', [TugasController::class, 'excel'])->name('tugasExcel');

// Peserta
Route::get('peserta', [PesertaController::class, 'index'])->name('peserta');
Route::get('peserta/notifikasi', [PesertaController::class, 'notifikasi'])->name('pesertaNotifikasi');
Route::get('peserta/create', [PesertaController::class, 'create'])->name('pesertaCreate');
Route::post('peserta/store', [PesertaController::class, 'store'])->name('pesertaStore');
Route::get('peserta/edit/{id}', [PesertaController::class, 'edit'])->name('pesertaEdit');
Route::post('peserta/update/{id}', [PesertaController::class, 'update'])->name('pesertaUpdate');
Route::delete('peserta/destroy/{id}', [PesertaController::class, 'destroy'])->name('pesertaDestroy');
Route::post('peserta/toggle-telat-bayar/{id}', [PesertaController::class, 'toggleTelatBayar'])->name('pesertaToggleTelatBayar');
Route::get('peserta/excel', [PesertaController::class, 'excel'])->name('pesertaExcel');
Route::get('peserta/pdf', [PesertaController::class, 'pdf'])->name('pesertaPdf');

});


});
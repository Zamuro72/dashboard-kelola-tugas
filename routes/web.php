<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerjalananDinasController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

route::middleware('isLogin')->group(function () {
    // login
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginProses'])->name('loginProses');
});

// logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

route::middleware('checkLogin')->group(function () {

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('tugas', [TugasController::class, 'index'])->name('tugas');
    Route::get('tugas/pdf', [TugasController::class, 'pdf'])->name('tugasPdf');

    // Pengajuan Lembur (Karyawan)
    Route::get('lembur', [LemburController::class, 'index'])->name('lembur');
    Route::get('lembur/create', [LemburController::class, 'create'])->name('lemburCreate');
    Route::post('lembur/store', [LemburController::class, 'store'])->name('lemburStore');
    Route::get('lembur/show/{id}', [LemburController::class, 'show'])->name('lemburShow');
    Route::get('lembur/edit/{id}', [LemburController::class, 'edit'])->name('lemburEdit');
    Route::post('lembur/update/{id}', [LemburController::class, 'update'])->name('lemburUpdate');
    Route::delete('lembur/destroy/{id}', [LemburController::class, 'destroy'])->name('lemburDestroy');
    Route::get('lembur/pdf/{id}', [LemburController::class, 'pdf'])->name('lemburPdf');

    // Perjalanan Dinas (Karyawan)
    Route::get('perdin', [PerjalananDinasController::class, 'index'])->name('perdin');
    Route::get('perdin/create', [PerjalananDinasController::class, 'create'])->name('perdinCreate');
    Route::post('perdin/store', [PerjalananDinasController::class, 'store'])->name('perdinStore');
    Route::get('perdin/show/{id}', [PerjalananDinasController::class, 'show'])->name('perdinShow');
    Route::get('perdin/edit/{id}', [PerjalananDinasController::class, 'edit'])->name('perdinEdit');
    Route::post('perdin/update/{id}', [PerjalananDinasController::class, 'update'])->name('perdinUpdate');
    Route::delete('perdin/destroy/{id}', [PerjalananDinasController::class, 'destroy'])->name('perdinDestroy');
    Route::get('perdin/pdf/{id}', [PerjalananDinasController::class, 'pdf'])->name('perdinPdf');

    // Marketing - Project Management
route::middleware('isMarketing')->group(function () {
    Route::get('marketing/project', [ProjectController::class, 'marketingIndex'])->name('marketing.project');
    Route::get('marketing/project/create', [ProjectController::class, 'marketingCreate'])->name('marketing.project.create');
    Route::post('marketing/project/store', [ProjectController::class, 'marketingStore'])->name('marketing.project.store');
    Route::get('marketing/project/show/{id}', [ProjectController::class, 'marketingShow'])->name('marketing.project.show');
    Route::get('marketing/project/edit/{id}', [ProjectController::class, 'marketingEdit'])->name('marketing.project.edit');
    Route::post('marketing/project/update/{id}', [ProjectController::class, 'marketingUpdate'])->name('marketing.project.update');
    Route::delete('marketing/project/destroy/{id}', [ProjectController::class, 'marketingDestroy'])->name('marketing.project.destroy');
});

// Operasional - Project Management
route::middleware('isOperasional')->group(function () {
    Route::get('operasional/project', [ProjectController::class, 'operasionalIndex'])->name('operasional.project');
    Route::get('operasional/project/show/{id}', [ProjectController::class, 'operasionalShow'])->name('operasional.project.show');
    Route::get('operasional/project/edit/{id}', [ProjectController::class, 'operasionalEdit'])->name('operasional.project.edit');
    Route::post('operasional/project/update/{id}', [ProjectController::class, 'operasionalUpdate'])->name('operasional.project.update');
});

// Supporting - Project Management (tambahkan di dalam middleware isAdminOrSupporting yang sudah ada)
Route::get('supporting/project', [ProjectController::class, 'supportingIndex'])->name('supporting.project');
Route::get('supporting/project/show/{id}', [ProjectController::class, 'supportingShow'])->name('supporting.project.show');
Route::get('supporting/project/edit/{id}', [ProjectController::class, 'supportingEdit'])->name('supporting.project.edit');
Route::post('supporting/project/update/{id}', [ProjectController::class, 'supportingUpdate'])->name('supporting.project.update');

    route::middleware('isAdmin')->group(function () {
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
        Route::get('peserta/import', [PesertaController::class, 'importForm'])->name('pesertaImportForm');
        Route::post('peserta/import', [PesertaController::class, 'import'])->name('pesertaImport');
        Route::get('peserta/edit/{id}', [PesertaController::class, 'edit'])->name('pesertaEdit');
        Route::post('peserta/update/{id}', [PesertaController::class, 'update'])->name('pesertaUpdate');
        Route::delete('peserta/destroy/{id}', [PesertaController::class, 'destroy'])->name('pesertaDestroy');
        Route::delete('peserta/delete-year/{tahun}', [PesertaController::class, 'destroyByTahun'])->name('pesertaDestroyByTahun');
        Route::post('peserta/toggle-telat-bayar/{id}', [PesertaController::class, 'toggleTelatBayar'])->name('pesertaToggleTelatBayar');
        Route::get('peserta/excel', [PesertaController::class, 'excel'])->name('pesertaExcel');
        Route::get('peserta/pdf', [PesertaController::class, 'pdf'])->name('pesertaPdf');
    });

    route::middleware('isAdminOrSupporting')->group(function () {
        // Admin Lembur
        Route::get('admin/lembur', [LemburController::class, 'adminIndex'])->name('adminLembur');

        // Admin Perjalanan Dinas
        Route::get('admin/perdin', [PerjalananDinasController::class, 'adminIndex'])->name('adminPerdin');
    });
});

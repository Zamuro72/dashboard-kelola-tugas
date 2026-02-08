<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotaPerdinController;
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
    Route::get('dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chartData');
    Route::get('dashboard/chart-details', [DashboardController::class, 'getChartDetails'])->name('dashboard.chartDetails');
    Route::get('dashboard/pie-chart-data', [DashboardController::class, 'getPieChartData'])->name('dashboard.pieChartData');

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

    // Nota Perhitungan Perjalanan Dinas
    Route::get('nota-perdin', [NotaPerdinController::class, 'index'])->name('notaPerdin');
    Route::get('nota-perdin/create', [NotaPerdinController::class, 'create'])->name('notaPerdinCreate');
    Route::post('nota-perdin/store', [NotaPerdinController::class, 'store'])->name('notaPerdinStore');
    Route::get('nota-perdin/show/{id}', [NotaPerdinController::class, 'show'])->name('notaPerdinShow');
    Route::delete('nota-perdin/destroy/{id}', [NotaPerdinController::class, 'destroy'])->name('notaPerdinDestroy');
    Route::get('nota-perdin/pdf/{id}', [NotaPerdinController::class, 'pdf'])->name('notaPerdinPdf');

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

    route::middleware('isSupporting')->group(function () {
        Route::get('supporting/project', [ProjectController::class, 'supportingIndex'])->name('supporting.project');
        Route::get('supporting/project/show/{id}', [ProjectController::class, 'supportingShow'])->name('supporting.project.show');
        Route::get('supporting/project/edit/{id}', [ProjectController::class, 'supportingEdit'])->name('supporting.project.edit');
        Route::post('supporting/project/update/{id}', [ProjectController::class, 'supportingUpdate'])->name('supporting.project.update');
    });

    // Operasional - Project Management
    route::middleware('isOperasional')->group(function () {
        Route::get('operasional/project', [ProjectController::class, 'operasionalIndex'])->name('operasional.project');
        Route::get('operasional/project/show/{id}', [ProjectController::class, 'operasionalShow'])->name('operasional.project.show');
        Route::get('operasional/project/edit/{id}', [ProjectController::class, 'operasionalEdit'])->name('operasional.project.edit');
        Route::post('operasional/project/update/{id}', [ProjectController::class, 'operasionalUpdate'])->name('operasional.project.update');
        Route::get('operasional/project/download/{id}/{type}', [ProjectController::class, 'operasionalDownload'])->name('operasional.project.download');
        Route::delete('operasional/project/destroy/{id}', [ProjectController::class, 'operasionalDestroy'])->name('operasional.project.destroy');
    });



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
    });

    route::middleware('isAdminOrSupporting')->group(function () {
        // Admin Lembur
        Route::get('admin/lembur', [LemburController::class, 'adminIndex'])->name('adminLembur');

        // Admin Perjalanan Dinas
        Route::get('admin/perdin', [PerjalananDinasController::class, 'adminIndex'])->name('adminPerdin');
    });

    // Route untuk Admin dan Marketing (Data Klien)
    Route::middleware(['auth'])->group(function () {

        // Halaman utama - Daftar Jasa
        Route::get('/klien', [KlienController::class, 'index'])->name('klien.index');
        Route::get('/klien/status/{status}', [KlienController::class, 'filterByStatus'])->name('klien.status');

        // Pilih tahun
        Route::get('/klien/{jasaId}/tahun', [KlienController::class, 'showTahun'])->name('klien.tahun');

        // Pilih skema (untuk jasa yang punya skema)
        Route::get('/klien/{jasaId}/tahun/{tahun}/skema', [KlienController::class, 'showSkema'])->name('klien.skema');

        // Data klien tanpa skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/data', [KlienController::class, 'showData'])->name('klien.data');

        // Data klien dengan skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/skema/{skemaId}/data', [KlienController::class, 'showData'])->name('klien.data.skema');

        // Form tambah klien tanpa skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/create', [KlienController::class, 'create'])->name('klien.create');

        // Form tambah klien dengan skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/skema/{skemaId}/create', [KlienController::class, 'create'])->name('klien.create.skema');

        // Simpan klien tanpa skema
        Route::post('/klien/{jasaId}/tahun/{tahun}/store', [KlienController::class, 'store'])->name('klien.store');

        // Simpan klien dengan skema
        Route::post('/klien/{jasaId}/tahun/{tahun}/skema/{skemaId}/store', [KlienController::class, 'store'])->name('klien.store.skema');

        // Edit klien
        Route::get('/klien/{id}/edit', [KlienController::class, 'edit'])->name('klien.edit');

        // Update klien
        Route::put('/klien/{id}', [KlienController::class, 'update'])->name('klien.update');

        // Hapus klien
        Route::delete('/klien/{id}', [KlienController::class, 'destroy'])->name('klien.destroy');

        // Notifikasi expired
        Route::get('/klien/notifikasi', [KlienController::class, 'notifikasi'])->name('klien.notifikasi');

        // Export Excel tanpa skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/excel', [KlienController::class, 'excel'])->name('klien.excel');

        // Export Excel dengan skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/skema/{skemaId}/excel', [KlienController::class, 'excel'])->name('klien.excel.skema');

        // Export PDF tanpa skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/pdf', [KlienController::class, 'pdf'])->name('klien.pdf');

        // Export PDF dengan skema
        Route::get('/klien/{jasaId}/tahun/{tahun}/skema/{skemaId}/pdf', [KlienController::class, 'pdf'])->name('klien.pdf.skema');

        // Import
        Route::get('/klien/import', [KlienController::class, 'importForm'])->name('klien.import.form');
        Route::post('/klien/import', [KlienController::class, 'import'])->name('klien.import');

        // Delete Data by Year
        Route::post('/klien/delete-year', [KlienController::class, 'deleteByYear'])->name('klien.deleteYear');
    });
});

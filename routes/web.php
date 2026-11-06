<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controller Pimpinan
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\AdminController;
use App\Http\Controllers\Pimpinan\AbsensiController;
use App\Http\Controllers\Pimpinan\BarangController;

// Controller Admin Absensi
use App\Http\Controllers\Absensi\Admin\DashboardController as AdminAbsensiDashboardController;
use App\Http\Controllers\Absensi\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Absensi\Admin\UserController as AdminUserController;
use App\Http\Controllers\Absensi\Admin\LaporanController;

// Controller Admin Barang
use App\Http\Controllers\Barang\Admin\DashboardController as AdminBarangDashboardController;
use App\Http\Controllers\Barang\Admin\BarangKendaraanController as AdminBarangController;
use App\Http\Controllers\Barang\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Barang\Admin\LaporanController as AdminLaporanController;

// Controller Magang
use App\Http\Controllers\Absensi\Magang\DashboardController as MagangDashboardController;

// Controller Pegawai
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Absensi\Pegawai\DashboardController as AbsensiPegawaiController;

//Controller Resepsionis
use App\Http\Controllers\Resepsionis\TamuController as ResepsionisTamuController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Resepsionis\StatistikController;




/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA (Redirect berdasarkan role)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;

        if ($role === 'pimpinan') {
            return redirect()->route('pimpinan.dashboard');
        }

        if ($role === 'admin_absensi') {
            return redirect()->route('absensi.admin.dashboard');
        }

        if ($role === 'admin_barang') {
            return redirect()->route('barang.admin.dashboard');
        }

        if ($role === 'magang') {
            return redirect()->route('absensi.magang.dashboard');
        }

        if ($role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| ROUTE PIMPINAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pimpinan'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {

        Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('admin', AdminController::class);

        Route::get('/absensi', [AbsensiController::class, 'index'])
            ->name('absensi.index');

        Route::get('/absensi/laporan', [AbsensiController::class, 'laporan'])
            ->name('absensi.laporan');

        Route::get('/barang', [BarangController::class, 'index'])
            ->name('barang.index');

        Route::get('/barang/laporan', [BarangController::class, 'laporan'])
            ->name('barang.laporan');

        Route::get('/export-pdf', [PimpinanDashboardController::class, 'exportPdf'])
            ->name('export.pdf');
    });


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN ABSENSI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_absensi'])
    ->prefix('absensi/admin')
    ->name('absensi.admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [AdminAbsensiDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */
        Route::resource('users', AdminUserController::class);

        /*
        |--------------------------------------------------------------------------
        | Data Absensi
        |--------------------------------------------------------------------------
        */
        Route::resource('data', AdminAbsensiController::class);

        /*
        |--------------------------------------------------------------------------
        | Laporan Absensi
        |--------------------------------------------------------------------------
        */
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan');

        /*
        |--------------------------------------------------------------------------
        | Export / Print PDF
        |--------------------------------------------------------------------------
        */
        Route::get('/pdf', [LaporanController::class, 'exportPdf'])
            ->name('pdf');


    });
/*
|--------------------------------------------------------------------------
| ROUTE ADMIN Barang (MODUL LENGKAP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_barang'])
    ->prefix('barang/admin')
    ->name('barang.admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminBarangDashboardController::class, 'index'])
            ->name('dashboard');

        // =============================
        // Manajemen User Pegawai
        // =============================
        Route::resource('user', \App\Http\Controllers\Barang\Admin\UserController::class);

        // =============================
        // Route khusus barang (HARUS DI ATAS resource)
        // =============================
        Route::get('barang/pilih', [AdminBarangController::class, 'pilih'])
            ->name('barang.pilih');

        Route::get('barang/import-form', [AdminBarangController::class, 'importForm'])
            ->name('barang.import.form');

        Route::post('barang/import', [AdminBarangController::class, 'import'])
            ->name('barang.import');

        // Route export barang
        Route::get('barang/export', [AdminBarangController::class, 'export'])
            ->name('barang.export');

        // =============================
        // CRUD Barang
        // =============================
        Route::resource('barang', AdminBarangController::class);

        // =============================
        // Peminjaman
        // =============================
        Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        Route::get('peminjaman/create', [AdminPeminjamanController::class, 'create'])
            ->name('peminjaman.create');

        Route::post('peminjaman', [AdminPeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::post('peminjaman/{id}/kembali', [AdminPeminjamanController::class, 'kembali'])
            ->name('peminjaman.kembali');

        // =============================
        // Laporan
        // =============================
        Route::get('laporan', [AdminLaporanController::class, 'index'])
            ->name('laporan.index');
        Route::get('laporan/pdf',[AdminLaporanController::class,'exportPdf'])
            ->name('laporan.pdf');
    });

/*
|--------------------------------------------------------------------------
| ROUTE MAGANG (ABSENSI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:magang'])
    ->prefix('magang')
    ->name('absensi.magang.')
    ->group(function () {

        Route::get('/dashboard', [MagangDashboardController::class, 'index'])
            ->name('dashboard');

        // Absen
        Route::get('/absen', [MagangDashboardController::class, 'formMasuk'])
            ->name('masuk.form');

        Route::post('/absen', [MagangDashboardController::class, 'storeMasuk'])
            ->name('masuk.store');

        Route::get('/absen-pulang', [MagangDashboardController::class, 'formPulang'])
            ->name('pulang.form');

        Route::post('/absen-pulang', [MagangDashboardController::class, 'storePulang'])
            ->name('pulang.store');

        Route::get('/riwayat', [MagangDashboardController::class,'riwayat'])
        ->name('riwayat');
    });


/*
|--------------------------------------------------------------------------
| ROUTE PEGAWAI ABSENSI DAN BARANG
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {

        // Dashboard utama pegawai
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])
            ->name('dashboard');

        // Menu Absensi → menuju dashboard absensi pegawai
        Route::get('/absensi', [PegawaiDashboardController::class, 'absensi'])
            ->name('absensi');

        // Menu Barang → menuju dashboard peminjaman pegawai
        Route::get('/barang', [PegawaiDashboardController::class, 'barang'])
            ->name('barang');
        Route::get('/laporan-peminjaman',
        [PegawaiDashboardController::class,'laporanPeminjaman'])
        ->name('laporan.index');
    });

/*
|--------------------------------------------------------------------------
| ROUTE PEMINJAMAN BARANG PEGAWAI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai/barang')
    ->name('pegawai.barang.')
    ->group(function () {

        // Halaman daftar barang
        Route::get('/', [PegawaiDashboardController::class, 'barang'])
            ->name('index');

        // Proses pinjam barang
        Route::post(
    '/pinjam/{id}',[PegawaiDashboardController::class,'pinjam'])
            ->name('pinjam');
        // Riwayat peminjaman pegawai
        Route::get('/riwayat', [PegawaiDashboardController::class, 'riwayatBarang'])
            ->name('riwayat');
    });


/*
|--------------------------------------------------------------------------
| ROUTE DASHBOARD ABSENSI PEGAWAI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('absensi/pegawai')
    ->name('absensi.pegawai.')
    ->group(function () {

        Route::get('/dashboard', [AbsensiPegawaiController::class, 'index'])
            ->name('dashboard');
        // WFO
        Route::get('/wfo', [AbsensiPegawaiController::class, 'formMasuk'])
            ->name('masuk.form');

        Route::post('/wfo', [AbsensiPegawaiController::class, 'storeMasuk'])
            ->name('masuk.store');

        Route::get('/wfo-pulang', [AbsensiPegawaiController::class, 'formPulang'])
            ->name('pulang.form');

        Route::post('/wfo-pulang', [AbsensiPegawaiController::class, 'storePulang'])
            ->name('pulang.store');

        // WFH
        Route::get('/wfh', [AbsensiPegawaiController::class, 'formWfhMasuk'])
            ->name('wfh.masuk.form');

        Route::post('/wfh', [AbsensiPegawaiController::class, 'storeWfhMasuk'])
            ->name('wfh.masuk.store');

        Route::get('/wfh-pulang', [AbsensiPegawaiController::class, 'formWfhPulang'])
            ->name('wfh.pulang.form');

        Route::post('/wfh-pulang', [AbsensiPegawaiController::class, 'storeWfhPulang'])
            ->name('wfh.pulang.store');

        Route::post('/track', [AbsensiPegawaiController::class, 'track'])
            ->name('track');

        Route::get('/riwayat', [AbsensiPegawaiController::class, 'riwayat'])
            ->name('riwayat');
    });


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Resepsionis
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:resepsionis'])
    ->prefix('resepsionis')
    ->name('resepsionis.')
    ->group(function () {

        /*
        |----------------------------------
        | DASHBOARD
        |----------------------------------
        */
        Route::get('/dashboard',
            [ResepsionisDashboardController::class,'index']
        )->name('dashboard');


        /*
        |----------------------------------
        | STATISTIK
        |----------------------------------
        */
        Route::get('/statistik',
            [StatistikController::class,'index']
        )->name('statistik');


        /*
        |----------------------------------
        | DATA TAMU
        |----------------------------------
        */
        Route::get('/tamu',
            [ResepsionisTamuController::class,'index']
        )->name('tamu');


        /*
        |----------------------------------
        | INPUT TAMU
        |----------------------------------
        */
        Route::get('/tamu/input',
            [ResepsionisTamuController::class,'create']
        )->name('tamu.create');

        Route::post('/tamu/store',
            [ResepsionisTamuController::class,'store']
        )->name('tamu.store');


        /*
        |----------------------------------
        | EDIT TAMU
        |----------------------------------
        */
        Route::get('/tamu/edit/{id}',
            [ResepsionisTamuController::class,'edit']
        )->name('tamu.edit');

        Route::put('/tamu/update/{id}',
            [ResepsionisTamuController::class,'update']
        )->name('tamu.update');


        /*
        |----------------------------------
        | CHECKOUT TAMU
        |----------------------------------
        */
        Route::put('/tamu/pulang/{id}',
            [ResepsionisTamuController::class,'pulang']
        )->name('tamu.pulang');


        /*
        |----------------------------------
        | HAPUS TAMU
        |----------------------------------
        */
        Route::delete('/tamu/{id}',
            [ResepsionisTamuController::class,'destroy']
        )->name('tamu.destroy');


        /*
        |----------------------------------
        | DOWNLOAD DATA TAMU
        |----------------------------------
        */
        Route::get('/tamu/download',
            [ResepsionisTamuController::class,'download']
        )->name('tamu.download');

});
require __DIR__ . '/auth.php';
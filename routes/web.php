<?php

use App\Http\Controllers\Admin\AkunControll;
use App\Http\Controllers\Admin\EkstrakurikulerControll;
use App\Http\Controllers\Admin\GuruControll;
use App\Http\Controllers\Admin\MainControll;
use App\Http\Controllers\Admin\PengumumanControll;
use App\Http\Controllers\Admin\SiswaControll;
use App\Http\Controllers\Guru\AbsenController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Guru\MainControllGuru;
use App\Http\Controllers\Guru\RekapNilaiController;
use App\Http\Controllers\LoginController;
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

Route::get('/', [MainControll::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('ekstrakurikuler', EkstrakurikulerControll::class);
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('gurus', GuruControll::class);
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('siswa', SiswaControll::class);
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('pengumuman', PengumumanControll::class);
});
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('users', AkunControll::class);
// });

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('users', AkunControll::class);
    Route::get('users/data', [AkunControll::class, 'getDataByRole']);
});



Route::get('/guru', [MainControllGuru::class, 'index'])->name('guru.dashboard')->middleware(['auth', 'role:guru']);

Route::get('/pengumuman/{id}', [MainControllGuru::class, 'show'])->name('pengumuman.show');

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.kelas.')->group(function () {
    Route::get('/kelas', [KelasController::class, 'index'])->name('index');
    Route::get('/show/kelas/{id}', [KelasController::class, 'show'])->name('show');
    Route::patch('/kelas-ekstra/{id}/konfirmasi', [KelasController::class, 'konfirmasi'])->name('kelasEkstra.konfirmasi');
    Route::post('/kelas-ekstra/mulai/{id}', [KelasController::class, 'mulaiKelas'])->name('kelasEkstra.mulai');
    Route::post('/kelas-ekstra/akhir/{id}', [KelasController::class, 'akhirKelas'])->name('kelasEkstra.akhir');
    Route::post('absen/generate', [AbsenController::class, 'generate'])->name('absen.generate');
    
    Route::post('/guru-session/{id}', [AbsenController::class, 'getSesi'])->name('rekap.absen');
    Route::get('/guru/kelas/rekap', [AbsenController::class, 'getRekap'])->name('get.absen');
    Route::get('/guru/absen-rekap/{id}', [AbsenController::class, 'absennya'])->name('ini.rekap');
    Route::patch('/absen-izin', [AbsenController::class, 'izin'])->name('izin');
    Route::delete('/absen-delete', [AbsenController::class, 'delete'])->name('delete');
    



    // Route::get('/kelas/{id}/detail', [KelasController::class, 'showMembers'])->name('kelas_ekstra.members');

});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.absen.')->group(function () {
    Route::get('/absen', [AbsenController::class, 'index'])->name('index');
});

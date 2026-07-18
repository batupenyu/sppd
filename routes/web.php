<?php

use App\Http\Controllers\AsnController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\DrhSatyalancanaController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\SpdController;
use App\Http\Controllers\SpmtController;
use App\Http\Controllers\SptjmController;
use App\Http\Controllers\SuratCutiController;
use App\Http\Controllers\SuratDispensasiController;
use App\Http\Controllers\SuratTugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('asns/export', [AsnController::class, 'export'])->name('asns.export');
Route::get('asns/import', [AsnController::class, 'import'])->name('asns.import');
Route::post('asns/import', [AsnController::class, 'importStore'])->name('asns.import.store');
Route::delete('asns/destroy-all', [AsnController::class, 'destroyAll'])->name('asns.destroy.all');
Route::resource('asns', AsnController::class);

Route::get('data-siswa/export/csv', [DataSiswaController::class, 'exportCsv'])->name('data-siswa.export.csv');
Route::get('data-siswa/export/xlsx', [DataSiswaController::class, 'exportXlsx'])->name('data-siswa.export.xlsx');
Route::get('data-siswa/import', [DataSiswaController::class, 'import'])->name('data-siswa.import');
Route::post('data-siswa/import', [DataSiswaController::class, 'importStore'])->name('data-siswa.import.store');
Route::delete('data-siswa/destroy-all', [DataSiswaController::class, 'destroyAll'])->name('data-siswa.destroy.all');
Route::resource('data-siswa', DataSiswaController::class)->parameter('data-siswa', 'siswa');

Route::resource('spds', SpdController::class)->except(['show', 'destroy']);
Route::delete('spds/{spd}', [SpdController::class, 'destroy'])->name('spds.destroy');
Route::get('spds/{spd}/print', [SpdController::class, 'print'])->name('spds.print');

Route::resource('logos', LogoController::class)->except(['show']);
Route::get('logos/{logo}/image', [LogoController::class, 'show'])->name('logos.image');
Route::get('api/kop-surat', [LogoController::class, 'apiKopSurat'])->name('api.kop-surat');

Route::resource('sptjms', SptjmController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('sptjms/{sptjm}', [SptjmController::class, 'destroy'])->name('sptjms.destroy');
Route::get('sptjms/{sptjm}/print', [SptjmController::class, 'print'])->name('sptjms.print');
Route::resource('drh-satyalancana', DrhSatyalancanaController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('drh-satyalancana/{drh}', [DrhSatyalancanaController::class, 'destroy'])->name('drh-satyalancana.destroy');
Route::get('drh-satyalancana/{drh}/print', [DrhSatyalancanaController::class, 'print'])->name('drh-satyalancana.print');
Route::resource('surat-tugas', SuratTugasController::class)
    ->except(['show', 'destroy'])
    ->parameter('surat-tugas', 'surat_tugas');
Route::delete('surat-tugas/{surat_tugas}', [SuratTugasController::class, 'destroy'])->name('surat-tugas.destroy');
Route::get('surat-tugas/{surat_tugas}/print', [SuratTugasController::class, 'print'])->name('surat-tugas.print');
Route::resource('spmts', SpmtController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('spmts/{spmt}', [SpmtController::class, 'destroy'])->name('spmts.destroy');
Route::get('spmts/{spmt}/print', [SpmtController::class, 'print'])->name('spmts.print');
Route::resource('surat-cutis', SuratCutiController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-cutis/{surat_cuti}', [SuratCutiController::class, 'destroy'])->name('surat-cutis.destroy');
Route::get('surat-cutis/{surat_cuti}/print', [SuratCutiController::class, 'print'])->name('surat-cutis.print');
Route::resource('surat-dispensasis', SuratDispensasiController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-dispensasis/{surat_dispensasi}', [SuratDispensasiController::class, 'destroy'])->name('surat-dispensasis.destroy');
Route::get('surat-dispensasis/{surat_dispensasi}/print', [SuratDispensasiController::class, 'print'])->name('surat-dispensasis.print');

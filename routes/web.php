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
use App\Http\Controllers\SuratKeteranganController;
use App\Http\Controllers\SuratKp4Controller;
use App\Http\Controllers\SuratPanggilanSiswaController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\SuratRekomendasiController;
use App\Http\Controllers\SuratResmiController;
use App\Http\Controllers\SuratSantunanController;
use App\Http\Controllers\SuratNodinController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\SuratUmumController;
use App\Http\Controllers\SuratUndanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('asns/export', [AsnController::class, 'export'])->name('asns.export');
Route::get('asns/export/xlsx', [AsnController::class, 'exportXlsx'])->name('asns.export.xlsx');
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
    ->only(['index', 'create', 'store', 'edit', 'update'])
    ->parameter('drh-satyalancana', 'drh');
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
Route::resource('surat-keterangans', SuratKeteranganController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-keterangans/{surat_keterangan}', [SuratKeteranganController::class, 'destroy'])->name('surat-keterangans.destroy');
Route::get('surat-keterangans/{surat_keterangan}/print', [SuratKeteranganController::class, 'print'])->name('surat-keterangans.print');
Route::resource('surat-kp4s', SuratKp4Controller::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-kp4s/{surat_kp4}', [SuratKp4Controller::class, 'destroy'])->name('surat-kp4s.destroy');
Route::get('surat-kp4s/{surat_kp4}/print', [SuratKp4Controller::class, 'print'])->name('surat-kp4s.print');
Route::resource('surat-panggilan-siswas', SuratPanggilanSiswaController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-panggilan-siswas/{surat_panggilan_siswa}', [SuratPanggilanSiswaController::class, 'destroy'])->name('surat-panggilan-siswas.destroy');
Route::get('surat-panggilan-siswas/{surat_panggilan_siswa}/print', [SuratPanggilanSiswaController::class, 'print'])->name('surat-panggilan-siswas.print');
Route::resource('surat-pengantars', SuratPengantarController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-pengantars/{surat_pengantar}', [SuratPengantarController::class, 'destroy'])->name('surat-pengantars.destroy');
Route::get('surat-pengantars/{surat_pengantar}/print', [SuratPengantarController::class, 'print'])->name('surat-pengantars.print');
Route::resource('surat-rekomendasis', SuratRekomendasiController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-rekomendasis/{surat_rekomendasi}', [SuratRekomendasiController::class, 'destroy'])->name('surat-rekomendasis.destroy');
Route::get('surat-rekomendasis/{surat_rekomendasi}/print', [SuratRekomendasiController::class, 'print'])->name('surat-rekomendasis.print');
Route::resource('surat-resmis', SuratResmiController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-resmis/{surat_resmi}', [SuratResmiController::class, 'destroy'])->name('surat-resmis.destroy');
Route::get('surat-resmis/{surat_resmi}/print', [SuratResmiController::class, 'print'])->name('surat-resmis.print');
Route::resource('surat-santunans', SuratSantunanController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-santunans/{surat_santunan}', [SuratSantunanController::class, 'destroy'])->name('surat-santunans.destroy');
Route::get('surat-santunans/{surat_santunan}/print', [SuratSantunanController::class, 'print'])->name('surat-santunans.print');
Route::resource('surat-umums', SuratUmumController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-umums/{surat_umum}', [SuratUmumController::class, 'destroy'])->name('surat-umums.destroy');
Route::get('surat-umums/{surat_umum}/print', [SuratUmumController::class, 'print'])->name('surat-umums.print');
Route::resource('surat-undangans', SuratUndanganController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-undangans/{surat_undangan}', [SuratUndanganController::class, 'destroy'])->name('surat-undangans.destroy');
Route::get('surat-undangans/{surat_undangan}/print', [SuratUndanganController::class, 'print'])->name('surat-undangans.print');
Route::resource('surat-nodins', SuratNodinController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);
Route::delete('surat-nodins/{surat_nodin}', [SuratNodinController::class, 'destroy'])->name('surat-nodins.destroy');
Route::get('surat-nodins/{surat_nodin}/print', [SuratNodinController::class, 'print'])->name('surat-nodins.print');
Route::get('surat-nodins/{surat_nodin}/lampiran', [SuratNodinController::class, 'lampiran'])->name('surat-nodins.lampiran');

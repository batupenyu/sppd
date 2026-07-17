<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsnController;
use App\Http\Controllers\SpdController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\SuratTugasController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('asns/export', [AsnController::class, 'export'])->name('asns.export');
Route::get('asns/import', [AsnController::class, 'import'])->name('asns.import');
Route::post('asns/import', [AsnController::class, 'importStore'])->name('asns.import.store');
Route::delete('asns/destroy-all', [AsnController::class, 'destroyAll'])->name('asns.destroy.all');
Route::resource('asns', AsnController::class);

Route::resource('spds', SpdController::class)->except(['show', 'destroy']);
Route::delete('spds/{spd}', [SpdController::class, 'destroy'])->name('spds.destroy');
Route::get('spds/{spd}/print', [SpdController::class, 'print'])->name('spds.print');

Route::resource('logos', LogoController::class)->except(['show']);
Route::get('logos/{logo}/image', [LogoController::class, 'show'])->name('logos.image');
Route::get('api/kop-surat', [LogoController::class, 'apiKopSurat'])->name('api.kop-surat');

Route::resource('surat-tugas', SuratTugasController::class)
    ->except(['show', 'destroy'])
    ->parameter('surat-tugas', 'surat_tugas');
Route::delete('surat-tugas/{surat_tugas}', [SuratTugasController::class, 'destroy'])->name('surat-tugas.destroy');
Route::get('surat-tugas/{surat_tugas}/print', [SuratTugasController::class, 'print'])->name('surat-tugas.print');

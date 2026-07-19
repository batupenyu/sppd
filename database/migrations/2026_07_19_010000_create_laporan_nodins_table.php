<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_nodins', function (Blueprint $table) {
            $table->id();
            $table->string('kepada')->nullable();
            $table->string('dari')->nullable();
            $table->string('nomor')->nullable();
            $table->string('lampiran')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('perihal')->nullable();
            $table->text('dasar_pelaksanaan')->nullable();
            $table->text('tujuan')->nullable();
            $table->string('peserta1_nama')->nullable();
            $table->string('peserta1_nip')->nullable();
            $table->string('peserta1_jabatan')->nullable();
            $table->string('peserta2_nama')->nullable();
            $table->string('peserta2_nip')->nullable();
            $table->string('peserta2_jabatan')->nullable();
            $table->date('pelaksanaan_tanggal')->nullable();
            $table->string('pelaksanaan_jam')->nullable();
            $table->string('pelaksanaan_tempat')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('kop_surat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_nodins');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_nodins', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('hal')->nullable();
            $table->string('kepada')->nullable();
            $table->string('dari')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('dasar_surat')->nullable();
            $table->text('isi_surat')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->timestamps();
        });

        Schema::create('peserta_surat_usulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_nodin_id')->constrained('surat_nodins')->onDelete('cascade');
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('siswa_id')->nullable()->constrained('data_siswa')->onDelete('set null');
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_surat_usulans');
        Schema::dropIfExists('surat_nodins');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_kp4s', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('status_kepegawaian')->nullable();
            $table->string('masa_kerja_golongan')->nullable();
            $table->string('digaji_menurut')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('anggota_keluarga_kp4s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_kp4_id')->constrained('surat_kp4s')->onDelete('cascade');
            $table->string('nama');
            $table->date('tanggal_kelahiran')->nullable();
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('mendapat_tunjangan')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga_kp4s');
        Schema::dropIfExists('surat_kp4s');
    }
};

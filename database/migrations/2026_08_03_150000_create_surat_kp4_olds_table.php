<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_kp4_olds', function (Blueprint $table) {
            $table->id();
            $table->string('status_kepegawaian')->nullable();
            $table->string('masa_kerja_golongan')->nullable();
            $table->text('digaji_menurut')->nullable();
            $table->text('disamping_jabatan')->nullable();
            $table->string('penghasilan_disamping')->nullable();
            $table->string('pensiun_janda')->nullable();
            $table->string('kawin_sah')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('anggota_keluarga_kp4_olds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_kp4_old_id')->constrained('surat_kp4_olds')->onDelete('cascade');
            $table->string('nama');
            $table->string('nama_suami_istri')->nullable();
            $table->date('tanggal_kelahiran')->nullable();
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('penghasilan_sebulan')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('mendapat_tunjangan')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga_kp4_olds');
        Schema::dropIfExists('surat_kp4_olds');
    }
};

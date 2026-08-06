<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_penarikan_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('nama_sekolah_asal')->nullable();
            $table->string('nama_siswa')->nullable();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('kelas_jurusan')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('pekerjaan_orang_tua')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('tempat_tanggal_lahir')->nullable();
            $table->string('nama_sekolah_tujuan')->nullable();
            $table->text('alasan')->nullable();
            $table->string('nama_kota_sekolah')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('nama_wilayah_cabdinas')->nullable();
            $table->string('nama_kota_cabdin')->nullable();
            $table->string('nomor_surat_cabdin')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_penarikan_siswas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_panggilan_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->foreignId('siswa_id')->nullable()->constrained('data_siswa')->onDelete('set null');
            $table->string('keterangan_panggilan')->nullable();
            $table->date('tanggal_panggilan')->nullable();
            $table->string('waktu_panggilan')->nullable();
            $table->string('tempat_panggilan')->nullable();
            $table->foreignId('wali_kelas_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('guru_bk_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('wakasek_kesiswaan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_panggilan_siswas');
    }
};

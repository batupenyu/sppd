<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_tugas_pkls', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->text('dasar')->nullable();
            $table->json('pegawai_ids')->nullable();
            $table->json('siswa_ids')->nullable();
            $table->text('untuk_1')->nullable();
            $table->text('untuk_2')->nullable();
            $table->text('untuk_3')->nullable();
            $table->text('untuk_4')->nullable();
            $table->text('untuk_5')->nullable();
            $table->string('kegiatan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('pukul')->nullable();
            $table->string('tempat')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('tahun_anggaran')->nullable();
            $table->string('dikeluarkan_di')->nullable();
            $table->date('tanggal_dikeluarkan')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->nullOnDelete();
            $table->string('nama_penandatangan')->nullable();
            $table->string('nip_penandatangan')->nullable();
            $table->boolean('penandatangan_plt')->nullable();
            $table->boolean('penandatangan_an')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_tugas_pkls');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_cutis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('sifat_surat')->nullable();
            $table->string('lampiran_surat')->nullable();
            $table->string('perihal_surat')->nullable();
            $table->string('jenis_cuti')->nullable();
            $table->string('tujuan_surat')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->text('alasan_cuti')->nullable();
            $table->date('tanggal_mulai_cuti')->nullable();
            $table->date('tanggal_selesai_cuti')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_cutis');
    }
};

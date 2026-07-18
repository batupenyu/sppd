<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_santunans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->string('instansi_tujuan_surat')->nullable();
            $table->string('kota_tujuan_surat')->nullable();
            $table->text('isi_surat_pertama')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_santunans');
    }
};

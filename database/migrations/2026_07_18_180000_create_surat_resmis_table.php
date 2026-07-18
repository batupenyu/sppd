<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_resmis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal')->nullable();
            $table->string('pejabat_tujuan_surat')->nullable();
            $table->string('kota_tujuan_surat')->nullable();
            $table->text('pembuka_surat')->nullable();
            $table->text('isi_surat')->nullable();
            $table->text('penutup_surat')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('waktu_kegiatan')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('surat_resmi_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_resmi_id')->constrained('surat_resmis')->onDelete('cascade');
            $table->foreignId('asn_id')->constrained('asns')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_resmi_pegawai');
        Schema::dropIfExists('surat_resmis');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_undangans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('perihal')->nullable();
            $table->string('kepada_yth')->nullable();
            $table->foreignId('siswa_id')->nullable()->constrained('data_siswa')->onDelete('set null');
            $table->date('tanggal')->nullable();
            $table->string('waktu')->nullable();
            $table->string('tempat')->nullable();
            $table->text('acara')->nullable();
            $table->text('pembuka_surat')->nullable();
            $table->text('penutup_surat')->nullable();
            $table->foreignId('kepala_sekolah_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_undangans');
    }
};

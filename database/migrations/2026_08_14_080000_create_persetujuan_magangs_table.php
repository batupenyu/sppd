<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persetujuan_magangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('sifat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal')->nullable();
            $table->text('tujuan_surat')->nullable();
            $table->string('nomor_surat_kampus')->nullable();
            $table->date('tanggal_surat_kampus')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->json('mahasiswas')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan_magangs');
    }
};

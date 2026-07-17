<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asn_id')->constrained('asns')->onDelete('cascade');

            $table->string('nomor')->nullable();
            $table->string('lembar_ke')->nullable();
            $table->string('kode_no')->nullable();

            $table->string('pejabat_pemberi_tugas');
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan_instansi')->nullable();
            $table->string('tingkat_biaya')->nullable();

            $table->string('maksud_perjalanan');
            $table->string('alat_angkut')->nullable();

            $table->string('tempat_berangkat');
            $table->string('tempat_tujuan');

            $table->integer('lama_perjalanan')->nullable();
            $table->date('tanggal_berangkat')->nullable();
            $table->date('tanggal_kembali')->nullable();

            $table->string('instansi')->nullable();
            $table->string('akun')->nullable();
            $table->text('keterangan_lain')->nullable();

            $table->string('dikeluarkan_di')->nullable();
            $table->date('tanggal_dikeluarkan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spds');
    }
};

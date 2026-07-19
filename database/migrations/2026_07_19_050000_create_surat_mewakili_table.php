<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_mewakili', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->foreignId('penunjuk_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('penunjuk_nama')->nullable();
            $table->string('penunjuk_nip')->nullable();
            $table->string('penunjuk_pangkat_gol')->nullable();
            $table->string('penunjuk_jabatan')->nullable();
            $table->foreignId('ditunjuk_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('ditunjuk_nama')->nullable();
            $table->string('ditunjuk_nip')->nullable();
            $table->string('ditunjuk_instansi')->nullable();
            $table->string('ditunjuk_jabatan')->nullable();
            $table->text('keterangan_menunjuk')->nullable();
            $table->text('keterangan_mewakili')->nullable();
            $table->text('ketentuan_1')->nullable();
            $table->text('ketentuan_2')->nullable();
            $table->text('ketentuan_3')->nullable();
            $table->text('penutup')->nullable();
            $table->string('dikeluarkan_di')->nullable();
            $table->date('tanggal_dikeluarkan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_mewakili');
    }
};

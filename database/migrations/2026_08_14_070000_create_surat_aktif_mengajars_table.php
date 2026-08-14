<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_aktif_mengajars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_aktif_mengajars');
    }
};

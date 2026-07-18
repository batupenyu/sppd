<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sptjms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->text('isi_surat')->nullable();
            $table->text('penutup_surat')->nullable();
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->timestamps();
        });

        Schema::create('sptjm_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sptjm_id')->constrained('sptjms')->onDelete('cascade');
            $table->foreignId('asn_id')->constrained('asns')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sptjm_pegawai');
        Schema::dropIfExists('sptjms');
    }
};

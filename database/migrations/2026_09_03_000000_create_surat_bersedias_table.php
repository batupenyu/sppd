<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_bersedias', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('nama')->nullable();
            $table->string('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('hp_wa')->nullable();
            $table->enum('status', ['bersedia', 'tidak_bersedia'])->default('bersedia');
            $table->string('tempat_ditetapkan')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('penandatangan_id')->nullable();
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('asns')->onDelete('set null');
            $table->foreign('penandatangan_id')->references('id')->on('asns')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_bersedias');
    }
};

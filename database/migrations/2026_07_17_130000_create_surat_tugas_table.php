<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();

            $table->text('dasar_1')->nullable();
            $table->text('dasar_2')->nullable();

            $table->string('nama_1')->nullable();
            $table->string('pangkat_golongan_1')->nullable();
            $table->string('nip_1')->nullable();
            $table->string('jabatan_1')->nullable();

            $table->string('nama_2')->nullable();
            $table->string('pangkat_golongan_2')->nullable();
            $table->string('nip_2')->nullable();
            $table->string('jabatan_2')->nullable();

            $table->text('untuk_1')->nullable();
            $table->text('untuk_2')->nullable();
            $table->text('untuk_3')->nullable();

            $table->string('dikeluarkan_di')->nullable();
            $table->date('tanggal_dikeluarkan')->nullable();
            $table->string('jabatan_penandatangan')->nullable();
            $table->string('nama_penandatangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};

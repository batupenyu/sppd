<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak_kp4_olds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_kp4_old_id')->constrained('surat_kp4_olds')->onDelete('cascade');
            $table->string('name');
            $table->string('anak')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('perkawinan')->nullable();
            $table->string('status_sekolah')->nullable();
            $table->string('status_beasiswa')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->boolean('kat')->default(1);
            $table->date('tgl_meninggal_cerai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak_kp4_olds');
    }
};

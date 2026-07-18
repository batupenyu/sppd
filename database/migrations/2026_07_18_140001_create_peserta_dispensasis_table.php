<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_dispensasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_dispensasi_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('kelas')->nullable();
            $table->string('ket')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_dispensasis');
    }
};

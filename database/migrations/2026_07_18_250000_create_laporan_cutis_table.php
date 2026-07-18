<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_cutis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asn_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->string('tahun')->nullable();
            $table->integer('alokasi_awal_tahun_n')->nullable();
            $table->integer('alokasi_awal_tahun_n_1')->nullable();
            $table->integer('alokasi_awal_tahun_n_2')->nullable();
            $table->integer('total_alokasi_awal')->nullable();
            $table->foreignId('penandatangan_id')->nullable()->constrained('asns')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_cutis');
    }
};

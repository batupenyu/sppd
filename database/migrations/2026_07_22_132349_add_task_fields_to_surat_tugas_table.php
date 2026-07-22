<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->text('kegiatan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('pukul')->nullable();
            $table->text('tempat')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('tahun_anggaran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropColumn([
                'kegiatan',
                'tanggal_mulai',
                'tanggal_selesai',
                'pukul',
                'tempat',
                'sumber_dana',
                'tahun_anggaran',
            ]);
        });
    }
};

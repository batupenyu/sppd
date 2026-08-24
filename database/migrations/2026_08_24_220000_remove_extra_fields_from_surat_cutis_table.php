<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_cutis', function (Blueprint $table) {
            $table->dropForeign(['kepala_cabang_id']);
            $table->dropForeign(['kepala_sekolah_id']);
            $table->dropColumn(['kepala_sekolah_id', 'kepala_cabang_id', 'alamat_cuti']);
        });
    }

    public function down(): void
    {
        Schema::table('surat_cutis', function (Blueprint $table) {
            $table->foreignId('kepala_sekolah_id')->nullable()->after('penandatangan_id')->constrained('asns')->onDelete('set null');
            $table->foreignId('kepala_cabang_id')->nullable()->after('kepala_sekolah_id')->constrained('asns')->onDelete('set null');
            $table->text('alamat_cuti')->nullable()->after('alasan_cuti');
        });
    }
};

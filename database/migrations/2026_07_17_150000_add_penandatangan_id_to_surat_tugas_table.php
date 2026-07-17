<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->foreignId('penandatangan_id')->nullable()->after('nama_penandatangan')->constrained('asns')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropForeign(['penandatangan_id']);
            $table->dropColumn('penandatangan_id');
        });
    }
};

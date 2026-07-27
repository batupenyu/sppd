<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_nodins', function (Blueprint $table) {
            $table->foreignId('pegawai_tugas_id')->nullable()->constrained('asns')->nullOnDelete()->after('penandatangan_an');
        });
    }

    public function down(): void
    {
        Schema::table('surat_nodins', function (Blueprint $table) {
            $table->dropForeign(['pegawai_tugas_id']);
            $table->dropColumn('pegawai_tugas_id');
        });
    }
};

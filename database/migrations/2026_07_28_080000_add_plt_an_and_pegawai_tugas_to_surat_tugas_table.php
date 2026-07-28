<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->boolean('penandatangan_plt')->default(false)->after('nip_penandatangan');
            $table->boolean('penandatangan_an')->default(false)->after('penandatangan_plt');
            $table->foreignId('pegawai_tugas_id')->nullable()->constrained('asns')->nullOnDelete()->after('penandatangan_an');
        });
    }

    public function down(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropForeign(['pegawai_tugas_id']);
            $table->dropColumn(['penandatangan_plt', 'penandatangan_an', 'pegawai_tugas_id']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_cutis', function (Blueprint $table) {
            $table->integer('jumlah_hari')->nullable()->after('tanggal_selesai_cuti');
        });
    }

    public function down(): void
    {
        Schema::table('surat_cutis', function (Blueprint $table) {
            $table->dropColumn('jumlah_hari');
        });
    }
};

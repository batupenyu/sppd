<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_bersedias', function (Blueprint $table) {
            $table->text('isi_surat')->nullable()->after('status');
            $table->text('penutup_surat')->nullable()->after('isi_surat');
        });
    }

    public function down(): void
    {
        Schema::table('surat_bersedias', function (Blueprint $table) {
            $table->dropColumn(['isi_surat', 'penutup_surat']);
        });
    }
};

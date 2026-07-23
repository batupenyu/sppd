<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_panggilan_siswas', function (Blueprint $table) {
            $table->boolean('guru_bk_an')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('surat_panggilan_siswas', function (Blueprint $table) {
            $table->dropColumn(['guru_bk_an']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota_keluarga_kp4s', function (Blueprint $table) {
            $table->string('nama_suami_istri')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('anggota_keluarga_kp4s', function (Blueprint $table) {
            $table->dropColumn('nama_suami_istri');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->string('lembar_ke')->nullable()->after('id');
            $table->string('kode_no')->nullable()->after('lembar_ke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropColumn(['lembar_ke', 'kode_no']);
        });
    }
};

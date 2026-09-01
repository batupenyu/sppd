<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asns', function (Blueprint $table) {
            $table->text('nama_opd_indu')->nullable()->after('unit_kerja');
        });
    }

    public function down(): void
    {
        Schema::table('asns', function (Blueprint $table) {
            $table->dropColumn('nama_opd_indu');
        });
    }
};
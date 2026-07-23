<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photo_nodins', function (Blueprint $table) {
            $table->foreignId('laporan_nodin_id')->nullable()->constrained('laporan_nodins')->onDelete('cascade')->after('surat_nodin_id');
        });
    }

    public function down(): void
    {
        Schema::table('photo_nodins', function (Blueprint $table) {
            $table->dropForeign(['laporan_nodin_id']);
            $table->dropColumn('laporan_nodin_id');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_nodins', function (Blueprint $table) {
            $table->boolean('dari_an')->default(false)->after('dari_plt');
            $table->boolean('penandatangan_an')->default(false)->after('penandatangan_plt');
        });
    }

    public function down(): void
    {
        Schema::table('surat_nodins', function (Blueprint $table) {
            $table->dropColumn(['dari_an', 'penandatangan_an']);
        });
    }
};

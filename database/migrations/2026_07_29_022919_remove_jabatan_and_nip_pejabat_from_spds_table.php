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
        Schema::table('spds', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'nip_pejabat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spds', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('pejabat_pemberi_tugas');
            $table->string('nip_pejabat')->nullable()->after('jabatan');
        });
    }
};

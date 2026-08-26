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
        Schema::table('form_cutis', function (Blueprint $table) {
            $table->string('plt_plh')->nullable()->after('telepon');
            $table->string('plt_plh_kepala_cabang')->nullable()->after('plt_plh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_cutis', function (Blueprint $table) {
            $table->dropColumn(['plt_plh_kepala_cabang', 'plt_plh']);
        });
    }
};

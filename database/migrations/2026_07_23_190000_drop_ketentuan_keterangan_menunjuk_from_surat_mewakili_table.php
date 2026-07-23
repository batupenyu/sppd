<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_mewakili', function (Blueprint $table) {
            $table->dropColumn(['ketentuan', 'keterangan_menunjuk']);
        });
    }

    public function down(): void
    {
        Schema::table('surat_mewakili', function (Blueprint $table) {
            $table->text('keterangan_menunjuk')->nullable();
            $table->json('ketentuan')->nullable();
        });
    }
};

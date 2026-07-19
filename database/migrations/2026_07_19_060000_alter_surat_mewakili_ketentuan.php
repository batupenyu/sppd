<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_mewakili', function (Blueprint $table) {
            $table->dropColumn(['ketentuan_1', 'ketentuan_2', 'ketentuan_3']);
            $table->json('ketentuan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('surat_mewakili', function (Blueprint $table) {
            $table->dropColumn('ketentuan');
            $table->text('ketentuan_1')->nullable();
            $table->text('ketentuan_2')->nullable();
            $table->text('ketentuan_3')->nullable();
        });
    }
};

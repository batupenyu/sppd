<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_kp4_olds', function (Blueprint $table) {
            if (Schema::hasColumn('surat_kp4_olds', 'kawin_sah')) {
                $table->dropColumn('kawin_sah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_kp4_olds', function (Blueprint $table) {
            if (! Schema::hasColumn('surat_kp4_olds', 'kawin_sah')) {
                $table->string('kawin_sah')->nullable();
            }
        });
    }
};

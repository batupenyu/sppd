<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->string('yth')->nullable()->after('tujuan_surat');
            $table->string('di')->nullable()->after('yth');
        });
    }

    public function down(): void
    {
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->dropColumn(['yth', 'di']);
        });
    }
};

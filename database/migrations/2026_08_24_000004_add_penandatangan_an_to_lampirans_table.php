<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lampirans', function (Blueprint $table) {
            $table->boolean('penandatangan_an')->default(false)->after('penandatangan_id');
        });
    }

    public function down(): void
    {
        Schema::table('lampirans', function (Blueprint $table) {
            $table->dropColumn('penandatangan_an');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drh_satyalancana', function (Blueprint $table) {
            $table->text('dasar')->nullable()->after('atasan_nip');
            $table->text('untuk')->nullable()->after('dasar');
        });
    }

    public function down(): void
    {
        Schema::table('drh_satyalancana', function (Blueprint $table) {
            $table->dropColumn(['dasar', 'untuk']);
        });
    }
};

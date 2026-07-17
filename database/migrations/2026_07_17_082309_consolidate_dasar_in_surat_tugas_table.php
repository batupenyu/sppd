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
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->text('dasar')->nullable()->after('nomor');
            $table->dropColumn(['dasar_1', 'dasar_2']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->text('dasar_1')->nullable();
            $table->text('dasar_2')->nullable();
            $table->dropColumn('dasar');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photo_nodins', function (Blueprint $table) {
            $table->foreignId('surat_nodin_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('photo_nodins', function (Blueprint $table) {
            $table->foreignId('surat_nodin_id')->nullable(false)->change();
        });
    }
};

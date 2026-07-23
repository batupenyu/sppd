<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('surat_umums', 'surat_pernyataans');
    }

    public function down(): void
    {
        Schema::rename('surat_pernyataans', 'surat_umums');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_nodins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_nodin_id')->constrained('surat_nodins')->onDelete('cascade');
            $table->string('caption')->nullable();
            $table->string('mime')->nullable();
            $table->binary('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_nodins');
    }
};

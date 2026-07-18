<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drh_satyalancana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asn_id')->constrained('asns')->onDelete('cascade');

            $table->string('nip_lama')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pangkat')->nullable();
            $table->date('tmt_pangkat')->nullable();
            $table->string('no_sk_cpns')->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->string('jabatan_terakhir')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('tanda_kehormatan')->nullable();
            $table->date('tgl_kepres')->nullable();
            $table->string('no_kepres')->nullable();
            $table->text('hukuman_disiplin')->nullable();
            $table->text('cltn')->nullable();

            $table->string('atasan_nama')->nullable();
            $table->string('atasan_nip')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drh_satyalancana');
    }
};

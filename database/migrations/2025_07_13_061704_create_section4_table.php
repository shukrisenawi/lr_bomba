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
        Schema::create('section4', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('peningkatan_kualiti_kerja');
            $table->integer('kesilapan_kerja');
            $table->integer('kelajuan_kerja');
            $table->integer('keyakinan_diri');
            $table->integer('motivasi');
            $table->integer('kualiti_kerja_berkaitan');
            $table->integer('cadangkan_perubahan');
            $table->integer('penggunaan_kemahiran');
            $table->integer('keterbukaan_terhadap_perubahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section4');
    }
};

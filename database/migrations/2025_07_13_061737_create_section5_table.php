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
        Schema::create('section5', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('gugup');
            $table->integer('keputusasaan');
            $table->integer('gelisah');
            $table->integer('tahap_stres');
            $table->integer('perasaan_usaha');
            $table->integer('ketidakberhargaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section5');
    }
};

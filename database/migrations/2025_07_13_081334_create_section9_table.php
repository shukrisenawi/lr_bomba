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
        Schema::create('section9', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('keletihan');
            $table->integer('postur');
            $table->integer('kesihatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section9');
    }
};

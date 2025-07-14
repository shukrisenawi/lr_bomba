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
        Schema::create('section3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('diskresi_kemahiran');
            $table->integer('kuasa_keputusan');
            $table->integer('tuntutan_psikologi');
            $table->integer('sokongan_sosial_rakan');
            $table->integer('sokongan_sosial_penyelia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section3');
    }
};

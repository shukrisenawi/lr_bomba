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
        Schema::create('section2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('kebolehan_bekerja_sekarang');
            $table->integer('kebolehan_fizikal');
            $table->integer('kebolehan_mental');
            $table->integer('bilangan_masalah_kesihatan');
            $table->integer('gangguan_kerja');
            $table->integer('hari_tidak_bekerja');
            $table->integer('kebolehan_bekerja_akan_datang');
            $table->integer('kesenangan_aktiviti_harian');
            $table->integer('aktiviti_fizikal');
            $table->integer('harapan_untuk_masa_depan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section2');
    }
};

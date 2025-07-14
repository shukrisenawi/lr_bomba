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
        Schema::create('section7', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->integer('gangguan_tumpuan');
            $table->integer('kurang_selera_makan');
            $table->integer('perasaan_kekurangan');
            $table->integer('masalah_konsentrasi');
            $table->integer('perasaan_stres');
            $table->integer('perasaan_keputusasaan');
            $table->integer('pandangan_masa_depan');
            $table->integer('kesedihan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section7');
    }
};

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
        Schema::create('section11', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('section1')->onDelete('cascade');
            $table->text('ringkasan_pekerjaan');
            $table->text('keperluan_kelayakan');
            $table->json('tugas_utama');
            $table->json('tugas_tercabut');
            $table->json('tugas_sokongan');
            $table->json('tuntutan_fizikal');
            $table->json('tuntutan_mental');
            $table->json('keperluan_pendengaran');
            $table->json('keperluan_penglihatan');
            $table->json('persekitaran_kerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section11');
    }
};

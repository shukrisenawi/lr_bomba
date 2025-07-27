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
        // Update survey_scores table
        Schema::table('survey_scores', function (Blueprint $table) {
            $table->decimal('score', 8, 2)->nullable()->change();
        });

        // Update survey_answers table
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->decimal('score', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert survey_scores table
        Schema::table('survey_scores', function (Blueprint $table) {
            $table->integer('score')->nullable()->change();
        });

        // Revert survey_answers table
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->integer('score')->nullable()->change();
        });
    }
};

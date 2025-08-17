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
        Schema::table('respondents', function (Blueprint $table) {
            $table->string('health')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->decimal('bmi', 4, 2)->nullable();
            $table->string('blood_type', 3)->nullable();
            $table->text('health_issue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respondents', function (Blueprint $table) {
            $table->dropColumn([
                'health',
                'height',
                'weight',
                'bmi',
                'blood_type',
                'health_issue'
            ]);
        });
    }
};

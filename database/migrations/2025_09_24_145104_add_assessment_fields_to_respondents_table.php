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
             if (!Schema::hasColumn('respondents', 'assessment_summary')) {
                 $table->text('assessment_summary')->nullable();
             }
             if (!Schema::hasColumn('respondents', 'assessment_review')) {
                 $table->text('assessment_review')->nullable();
             }
             if (!Schema::hasColumn('respondents', 'assessment_date')) {
                 $table->timestamp('assessment_date')->nullable();
             }
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('respondents', function (Blueprint $table) {
             if (Schema::hasColumn('respondents', 'assessment_summary')) {
                 $table->dropColumn('assessment_summary');
             }
             if (Schema::hasColumn('respondents', 'assessment_review')) {
                 $table->dropColumn('assessment_review');
             }
             if (Schema::hasColumn('respondents', 'assessment_date')) {
                 $table->dropColumn('assessment_date');
             }
         });
     }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->nullable();
            $table->integer('age');
            $table->string('place_of_birth')->nullable();
            $table->string('gender');
            $table->string('ethnicity');
            $table->string('marital_status');
            $table->string('education_level');
            $table->decimal('monthly_income_self', 10, 2)->nullable();
            $table->decimal('household_income', 10, 2)->nullable();
            $table->decimal('monthly_income_spouse', 10, 2)->nullable();
            $table->decimal('other_income', 10, 2)->nullable();
            $table->string('current_position');
            $table->string('grade')->nullable();
            $table->string('location')->nullable();
            $table->string('position')->nullable();
            $table->string('state')->nullable();
            $table->string('years_of_service');
            $table->string('service_status');
            $table->boolean('consent_given')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('respondents');
    }
};

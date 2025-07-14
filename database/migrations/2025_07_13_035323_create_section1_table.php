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
        Schema::create('section1', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('age');
            $table->string('place_of_birth');
            $table->enum('gender', ['Lelaki', 'Perempuan']);
            $table->enum('ethnicity', ['Melayu', 'Cina', 'India', 'Lain-lain']);
            $table->enum('marital_status', ['Tidak pernah berkahwin', 'Berhijrah', 'Balu', 'Bercerai']);
            $table->enum('education_level', ['Tiada pendidikan formal', 'Sijil sekolah rendah', 'SRP/PMR/LCE', 'SPM/SPMV/MCE', 'STP/STPM/STAM/HSC', 'Sijil kemahiran', 'Diploma', 'Ijazah Sarjana Muda', 'Master', 'PhD', 'Lain-lain']);
            $table->decimal('monthly_income_self', 10, 2)->nullable();
            $table->decimal('monthly_income_spouse', 10, 2)->nullable();
            $table->decimal('other_income', 10, 2)->nullable();
            $table->string('current_position')->nullable();
            $table->string('grade')->nullable();
            $table->string('location')->nullable();
            $table->integer('years_of_service');
            $table->enum('service_status', ['Pegawai Sepenuh Masa', 'Pegawai Bomba Bantuan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section1');
    }
};

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Section1Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number' => fake()->phoneNumber,
            'email' => fake()->email,
            'age' => fake()->numberBetween(45, 65),
            'place_of_birth' => fake()->city,
            'gender' => fake()->randomElement(['Lelaki', 'Perempuan']),
            'ethnicity' => fake()->randomElement(['Melayu', 'Cina', 'India', 'Lain-lain']),
            'marital_status' => fake()->randomElement(['Tidak pernah berkahwin', 'Berhijrah', 'Balu', 'Bercerai']),
            'education_level' => fake()->randomElement(['Tiada pendidikan formal', 'Sijil sekolah rendah', 'SRP/PMR/LCE', 'SPM/SPMV/MCE', 'STP/STPM/STAM/HSC', 'Sijil kemahiran', 'Diploma', 'Ijazah Sarjana Muda', 'Master', 'PhD', 'Lain-lain']),
            'monthly_income_self' => fake()->randomFloat(2, 1000, 10000),
            'monthly_income_spouse' => fake()->randomFloat(2, 1000, 10000),
            'other_income' => fake()->randomFloat(2, 0, 5000),
            'current_position' => fake()->jobTitle,
            'grade' => fake()->randomElement(['JUSA A', 'JUSA B', 'JUSA C', 'KB 54/KB 14']),
            'location' => fake()->city,
            'years_of_service' => fake()->numberBetween(5, 35),
            'service_status' => fake()->randomElement(['Pegawai Sepenuh Masa', 'Pegawai Bomba Bantuan']),
        ];
    }
}

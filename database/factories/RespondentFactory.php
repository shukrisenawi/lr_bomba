<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Respondent;

class RespondentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Respondent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'phone_number' => $this->faker->phoneNumber,
            'age' => $this->faker->numberBetween(25, 55),
            'place_of_birth' => $this->faker->city,
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'ethnicity' => $this->faker->randomElement(['Melayu', 'Cina', 'India', 'Bumiputera', 'Lain-lain']),
            'marital_status' => $this->faker->randomElement(['Bujang', 'Berkahwin', 'Duda', 'Janda']),
            'education_level' => $this->faker->randomElement(['SPM', 'Diploma', 'Ijazah', 'Master', 'PhD']),
            'monthly_income_self' => $this->faker->randomElement([3000, 4000, 5000, 6000, 7000, 8000, 10000]),
            'monthly_income_spouse' => $this->faker->randomElement([0, 2000, 3000, 4000, 5000]),
            'other_income' => $this->faker->randomElement([0, 500, 1000, 1500]),
            'current_position' => $this->faker->jobTitle,
            'grade' => $this->faker->randomElement(['Gred 41', 'Gred 44', 'Gred 48', 'Gred 52', 'Gred 54']),
            'location' => $this->faker->city,
            'position' => $this->faker->randomElement(['Pegawai', 'Penolong Pegawai', 'Setiausaha', 'Pembantu Tadbir']),
            'state' => $this->faker->state,
            'years_of_service' => $this->faker->numberBetween(1, 30),
            'service_status' => $this->faker->randomElement(['Tetap', 'Kontrak', 'Sambilan']),
            'consent_given' => true,
        ];
    }
}

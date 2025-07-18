<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SurveyResponse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyScore>
 */
class SurveyScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'response_id' => SurveyResponse::factory(),
            'section' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']),
            'score' => $this->faker->numberBetween(0, 100),
            'category' => $this->faker->randomElement(['Rendah', 'Sederhana', 'Tinggi', 'Sangat Tinggi']),
            'recommendation' => $this->faker->paragraph,
        ];
    }
}

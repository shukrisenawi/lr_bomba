<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SurveyResponse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyAnswer>
 */
class SurveyAnswerFactory extends Factory
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
            'question_id' => $this->faker->randomElement(['A1', 'B2', 'C3', 'D4', 'E5']),
            'answer' => $this->faker->sentence,
        ];
    }
}

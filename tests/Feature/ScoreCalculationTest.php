<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\User;
use App\Http\Controllers\SurveyController;
use Database\Factories\SurveyResponseFactory;
use Database\Factories\SurveyAnswerFactory;


class ScoreCalculationTest extends TestCase
{
    use RefreshDatabase;

{
    public function test_score_calculation()
    {
        // Create test user and response
        $user = User::factory()->create();
        $response = SurveyResponse::factory()->create([
            'user_id' => $user->id,
            'survey_id' => 'B',
            'completed' => false
        ]);


        // Create test answers with different score formats
        (new SurveyAnswerFactory())->create([
            'response_id' => $response->id,
            'question_id' => 1,
            'answer' => 'Option 1 (3)',
            'score' => 3
        ]);

        (new SurveyAnswerFactory())->create([
            'response_id' => $response->id,
            'question_id' => 2,
            'answer' => '4', // Direct numeric answer
            'score' => 4
        ]);

        (new SurveyAnswerFactory())->create([
            'response_id' => $response->id,
            'question_id' => 3,
            'answer' => 'High (5)',
            'score' => 5
        ]);

        // Calculate score
        $controller = new SurveyController();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $controller->calculateScore($response, 'B', $surveyData);

        // Get calculated score
        $score = $response->scores()->latest()->first();

        // Assertions
        $this->assertNotNull($score);
        $this->assertEquals(80, $score->score); // (3+4+5)/15*100 = 80
        $this->assertContains($score->category, ['Tinggi', 'Sederhana', 'Rendah']);
        $this->assertNotEmpty($score->recommendation);
    }

    public function test_empty_answers()
    {
        $response = (new SurveyResponseFactory())->create([
            'survey_id' => 'B',
            'completed' => false
        ]);

        // No answers created

        $controller = new SurveyController();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $controller->calculateScore($response, 'B', $surveyData);

        $score = $response->scores()->latest()->first();
        $this->assertEquals(0, $score->score);
    }

    public function test_invalid_answer_formats()
    {
        $response = (new SurveyResponseFactory())->create([
            'survey_id' => 'B',
            'completed' => false
        ]);

        (new SurveyAnswerFactory())->create([
            'response_id' => $response->id,
            'question_id' => 1,
            'answer' => 'Invalid answer format',
            'score' => null
        ]);

        $controller = new SurveyController();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $controller->calculateScore($response, 'B', $surveyData);

        $score = $response->scores()->latest()->first();
        $this->assertNotNull($score);
    }
}

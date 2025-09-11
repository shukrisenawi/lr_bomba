<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use Illuminate\Support\Facades\DB;

class MedianScoreCalculationService
{
    /**
     * Calculate median scores for each subsection in section C
     */
    public function calculateMedianScoresForSectionC(): array
    {
        $subsections = [
            'Tuntutan Psikologi' => ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8'],
            'Kawalan Keputusan' => ['C9', 'C10', 'C11', 'C12', 'C13', 'C14', 'C15'],
            'Sokongan Sosial' => ['C16', 'C17', 'C18', 'C19', 'C20', 'C21']
        ];

        $medianScores = [];

        foreach ($subsections as $subsectionName => $questionIds) {
            $scores = $this->getAllScoresForQuestions($questionIds);
            $median = $this->calculateMedian($scores);
            $medianScores[$subsectionName] = [
                'median' => $median,
                'total_respondents' => count($scores),
                'question_count' => count($questionIds)
            ];
        }

        return $medianScores;
    }

    /**
     * Get all scores for specific questions from all respondents
     */
    private function getAllScoresForQuestions(array $questionIds): array
    {
        $scores = [];

        // Get all survey responses
        $responses = SurveyResponse::all();

        foreach ($responses as $response) {
            $totalScore = 0;
            $answeredQuestions = 0;

            foreach ($questionIds as $questionId) {
                $answer = $response->answers()->where('question_id', $questionId)->first();
                if ($answer && $answer->score !== null) {
                    $totalScore += $answer->score;
                    $answeredQuestions++;
                }
            }

            // Only include respondents who answered at least one question in this subsection
            if ($answeredQuestions > 0) {
                $scores[] = $totalScore;
            }
        }

        return $scores;
    }

    /**
     * Calculate median from array of scores
     */
    private function calculateMedian(array $scores): float
    {
        if (empty($scores)) {
            return 0.0;
        }

        sort($scores);
        $count = count($scores);

        if ($count % 2 == 0) {
            // Even number of scores
            $middle = $count / 2;
            return ($scores[$middle - 1] + $scores[$middle]) / 2;
        } else {
            // Odd number of scores
            $middle = floor($count / 2);
            return $scores[$middle];
        }
    }

    /**
     * Save median scores to database
     */
    public function saveMedianScores(array $medianScores): void
    {
        // Use the first available user for median scores
        $firstUser = \App\Models\User::first();
        if (!$firstUser) {
            throw new \Exception('No users found in database');
        }

        // Use a dummy response_id that exists, or create a special response for median scores
        $medianResponse = \App\Models\SurveyResponse::firstOrCreate(
            ['user_id' => $firstUser->id, 'survey_id' => 'C_median'],
            ['completed' => true]
        );

        foreach ($medianScores as $subsectionName => $data) {
            // Save as a special survey score entry
            SurveyScore::updateOrCreate(
                [
                    'response_id' => $medianResponse->id,
                    'section' => 'C_median_' . str_replace(' ', '_', strtolower($subsectionName))
                ],
                [
                    'score' => $data['median'],
                    'category' => 'Median Score',
                    'recommendation' => "Median skor {$subsectionName}: {$data['median']} (dari {$data['total_respondents']} responden)"
                ]
            );
        }
    }

    /**
     * Get median scores from database
     */
    public function getMedianScores(): array
    {
        $medianScores = [];

        // Find the first user
        $firstUser = \App\Models\User::first();
        if (!$firstUser) {
            return $medianScores;
        }

        // Find the median response
        $medianResponse = \App\Models\SurveyResponse::where('user_id', $firstUser->id)
            ->where('survey_id', 'C_median')
            ->first();

        if ($medianResponse) {
            $scores = SurveyScore::where('response_id', $medianResponse->id)
                ->where('section', 'like', 'C_median_%')
                ->get();

            foreach ($scores as $score) {
                $subsectionName = str_replace(['C_median_', '_'], ['', ' '], $score->section);
                $subsectionName = ucwords($subsectionName);
                $medianScores[$subsectionName] = $score->score;
            }
        }

        return $medianScores;
    }
}
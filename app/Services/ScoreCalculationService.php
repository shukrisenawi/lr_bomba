<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

class ScoreCalculationService
{
    /**
     * Calculate total score for a specific survey response
     */
    public function calculateTotalScoreForResponse(SurveyResponse $response): int
    {
        return $response->answers()
            ->whereNotNull('score')
            ->sum('score');
    }

    /**
     * Calculate total score for all answers across all survey responses for a user
     */
    public function calculateUserTotalScore(int $userId): int
    {
        return SurveyAnswer::whereHas('response', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereNotNull('score')
            ->sum('score');
    }

    /**
     * Calculate total score for a specific survey section
     */
    public function calculateSectionTotalScore(SurveyResponse $response, string $section): int
    {
        return SurveyAnswer::where('response_id', $response->id)
            ->where('section', $section)
            ->whereNotNull('score')
            ->sum('score');
    }

    /**
     * Get detailed score breakdown for a response
     */
    public function getScoreBreakdown(SurveyResponse $response): array
    {
        $answers = $response->answers()
            ->whereNotNull('score')
            ->get();

        return [
            'total_score' => $answers->sum('score'),
            'question_count' => $answers->count(),
            'average_score' => $answers->count() > 0 ? round($answers->avg('score'), 2) : 0,
            'answers' => $answers->map(function ($answer) {
                return [
                    'question_id' => $answer->question_id,
                    'answer' => $answer->answer,
                    'score' => $answer->score,
                    'value' => $answer->value
                ];
            })
        ];
    }

    /**
     * Update or create score record for a response
     */
    public function updateResponseScore(SurveyResponse $response, string $section, int $totalScore, string $category, string $recommendation): void
    {
        SurveyScore::updateOrCreate(
            [
                'response_id' => $response->id,
                'section' => $section
            ],
            [
                'score' => $totalScore,
                'category' => $category ?? '',
                'recommendation' => $recommendation ?? ''
            ]
        );
    }
}

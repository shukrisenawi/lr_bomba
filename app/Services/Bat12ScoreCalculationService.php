<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

class Bat12ScoreCalculationService
{
    /**
     * BAT12 Section G question mappings
     */
    private const BAT12_QUESTION_MAPPINGS = [
        'Keletihan' => [
            'G1',
            'G2',
            'G3',
        ],
        'Jarak mental' => [
            'G4',
            'G5',
            'G6'
        ],
        'Kemerosotan kognitif' => [
            'G7',
            'G8',
            'G9'
        ],
        'Kemerosotan emosi' => [
            'G10',
            'G11',
            'G12'
        ],
    ];

    /**
     * Calculate BAT12 Section G scores
     */
    public function calculateBat12SectionGScores(SurveyResponse $response): array
    {
        $answers = $response->answers()->get()->keyBy('question_id');

        $bat12Scores = [
            'Keletihan' => 0,
            'Jarak mental' => 0,
            'Kemerosotan kognitif' => 0,
            'Kemerosotan emosi' => 0,
            'Overall BAT12' => 0
        ];

        // Calculate Fatigue Score (Kelelahan)
        $fatigueTotal = $this->calculateCategoryScore($answers, 'Keletihan');
        $bat12Scores['Keletihan'] = $this->divideScore($fatigueTotal, 8);

        // Calculate Mental Distance Score
        $mentalDistanceTotal = $this->calculateCategoryScore($answers, 'Jarak mental');
        $bat12Scores['Jarak mental'] = $this->divideScore($mentalDistanceTotal, 5);

        // Calculate Cognitive Decline Score
        $cognitiveDeclineTotal = $this->calculateCategoryScore($answers, 'Kemerosotan kognitif');
        $bat12Scores['Kemerosotan kognitif'] = $this->divideScore($cognitiveDeclineTotal, 5);

        // Calculate Emotional Decline Score
        $emotionalDeclineTotal = $this->calculateCategoryScore($answers, 'Kemerosotan emosi');
        $bat12Scores['Kemerosotan emosi'] = $this->divideScore($emotionalDeclineTotal, 5);

        // Calculate Overall BAT12 Score
        $totalSum = $bat12Scores['Keletihan'] +
            $bat12Scores['Jarak mental'] +
            $bat12Scores['Kemerosotan kognitif'] +
            $bat12Scores['Kemerosotan emosi'];

        $bat12Scores['Overall BAT12'] = $this->divideScore($totalSum, 5);

        return $bat12Scores;
    }

    /**
     * Calculate score for a specific category
     */
    private function calculateCategoryScore($answers, string $category): int
    {

        $total = 0;
        $questions = self::BAT12_QUESTION_MAPPINGS[$category] ?? [];

        foreach ($questions as $questionKey) {
            if ($answers->has($questionKey) && $answers[$questionKey]->score !== null) {
                $total += (int)$answers[$questionKey]->score;
            }
        }

        return $total;
    }

    /**
     * Divide score by factor with proper rounding
     */
    private function divideScore(int $score, int $divisor): float
    {
        return $divisor > 0 ? round($score / $divisor, 2) : 0;
    }

    /**
     * Get BAT12 score interpretation
     */
    public function getBat12Interpretation(float $score): array
    {

        if ($score >= 4.0) {
            return [
                'category' => 'Tinggi',
                'description' => 'Tahap keletihan yang tinggi - perlu intervensi segera',
                'recommendation' => 'Segera dapatkan sokongan profesional dan pertimbangkan cuti rehat'
            ];
        } elseif ($score >= 3.0) {
            return [
                'category' => 'Sederhana',
                'description' => 'Tahap keletihan sederhana - perhatian diperlukan',
                'recommendation' => 'Ambil langkah-langkah pengurusan stres dan pertimbangkan sokongan'
            ];
        } elseif ($score >= 2.0) {
            return [
                'category' => 'Rendah',
                'description' => 'Tahap keletihan rendah - berada dalam tahap normal',
                'recommendation' => 'Teruskan amalan gaya hidup sihat'
            ];
        } else {
            return [
                'category' => 'Sangat Rendah',
                'description' => 'Tiada tanda keletihan yang ketara',
                'recommendation' => 'Kekalkan tahap kesihatan mental yang baik'
            ];
        }
    }

    /**
     * Save BAT12 scores to database
     */
    public function saveBat12Scores(SurveyResponse $response, array $bat12Scores): void
    {
        // Update or create BAT12 scores
        SurveyScore::updateOrCreate(
            [
                'response_id' => $response->id,
                'section' => 'G_BAT12'
            ],
            [
                'score' => $bat12Scores['Overall BAT12'],
                'category' => $this->getBat12Interpretation($bat12Scores['Overall BAT12'])['category'],
                'recommendation' => $this->getBat12Interpretation($bat12Scores['Overall BAT12'])['recommendation'],
                'metadata' => json_encode([
                    'Keletihan' => $bat12Scores['Keletihan'],
                    'Jarak mental' => $bat12Scores['Jarak mental'],
                    'Kemerosotan kognitif' => $bat12Scores['Kemerosotan kognitif'],
                    'Kemerosotan emosi' => $bat12Scores['Kemerosotan emosi']
                ])
            ]
        );
    }
}

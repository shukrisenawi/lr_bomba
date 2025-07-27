<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

class SectionDScoreCalculationService
{
    /**
     * Section D question mappings for each subsection
     */
    private const SECTION_D_QUESTION_MAPPINGS = [
        'Prestasi Tugas' => [
            'D1',
            'D2',
            'D3',
            'D4',
            'D5'
        ],
        'Prestasi Kontekstual' => [
            'D6',
            'D7',
            'D8',
            'D9',
            'D10',
            'D11',
            'D12',
            'D13'
        ],
        'Perilaku Kerja Tidak Produktif' => [
            'D14',
            'D15',
            'D16',
            'D17',
            'D18'
        ]
    ];

    /**
     * Calculate Section D scores using the new formulas
     */
    public function calculateSectionDScores(SurveyResponse $response): array
    {
        $answers = $response->answers()->get()->keyBy('question_id');

        $sectionDScores = [
            'Prestasi Tugas' => 0,
            'Prestasi Kontekstual' => 0,
            'Perilaku Kerja Tidak Produktif' => 0,
            'Keseluruhan' => 0
        ];

        // Calculate Prestasi Tugas Score
        $prestasiTugasTotal = $this->calculateCategoryScore($answers, 'Prestasi Tugas');
        $sectionDScores['Prestasi Tugas'] = $this->divideScore($prestasiTugasTotal, 5);

        // Calculate Prestasi Kontekstual Score
        $prestasiKontekstualTotal = $this->calculateCategoryScore($answers, 'Prestasi Kontekstual');
        $sectionDScores['Prestasi Kontekstual'] = $this->divideScore($prestasiKontekstualTotal, 8);

        // Calculate Perilaku Kerja Tidak Produktif Score
        $perilakuKerjaTotal = $this->calculateCategoryScore($answers, 'Perilaku Kerja Tidak Produktif');
        $sectionDScores['Perilaku Kerja Tidak Produktif'] = $this->divideScore($perilakuKerjaTotal, 5);

        // Calculate Overall Section D Score
        $totalSum = $sectionDScores['Prestasi Tugas'] +
            $sectionDScores['Prestasi Kontekstual'] +
            $sectionDScores['Perilaku Kerja Tidak Produktif'];

        $sectionDScores['Keseluruhan'] = $this->divideScore($totalSum, 3);

        return $sectionDScores;
    }

    /**
     * Calculate score for a specific category
     */
    private function calculateCategoryScore($answers, string $category): int
    {
        $total = 0;
        $questions = self::SECTION_D_QUESTION_MAPPINGS[$category] ?? [];

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
}

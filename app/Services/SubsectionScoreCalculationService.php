<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

class SubsectionScoreCalculationService
{
    /**
     * Calculate scores for each subsection within a section
     */
    public function calculateSubsectionScores(SurveyResponse $response, array $sectionData): array
    {
        $subsectionScores = [];

        if (!isset($sectionData['subsections']) || empty($sectionData['subsections'])) {
            return $subsectionScores;
        }

        $answers = $response->answers()->get()->keyBy('question_id');
        $sectionId = $sectionData['id'] ?? '';

        foreach ($sectionData['subsections'] as $subsection) {
            if (!isset($subsection['questions']) || empty($subsection['questions'])) {
                continue;
            }

            $subsectionTotal = 0;
            $questionCount = 0;
            $maxPossibleScore = 0;

            foreach ($subsection['questions'] as $question) {
                $questionId = $question['id'];

                if ($answers->has($questionId) && $answers[$questionId]->score !== null) {
                    $subsectionTotal += (int)$answers[$questionId]->score;
                    $questionCount++;
                }

                // Calculate max possible score for this question
                $maxScore = $this->calculateMaxScoreForQuestion($question);
                $maxPossibleScore += $maxScore;
            }

            if ($questionCount > 0) {
                // Special handling for Section D (Bahagian D) scoring
                if ($sectionId === 'D') {
                    $normalizedScore = $this->calculateSectionDScore($subsection['name'], $subsectionTotal, $questionCount);
                } else {
                    // Original calculation for other sections
                    $normalizedScore = $subsectionTotal;
                }

                $category = $this->determineCategory($normalizedScore, $sectionData, $subsection['name']);
                $recommendation = $this->getRecommendation($normalizedScore, $sectionData);

                $subsectionScores[] = [
                    'name' => $subsection['name'],
                    'score' => $normalizedScore,
                    'raw_score' => $subsectionTotal,
                    'max_possible' => $maxPossibleScore,
                    'category' => $category,
                    'recommendation' => $recommendation,
                    'question_count' => $questionCount
                ];
            }
        }

        return $subsectionScores;
    }

    /**
     * Calculate Section D scores with specific division formulas
     */
    private function calculateSectionDScore(string $subsectionName, int $totalScore, int $questionCount): float
    {
        switch ($subsectionName) {
            case 'Prestasi Tugas':
                return $questionCount > 0 ? round($totalScore / 5, 2) : 0;

            case 'Prestasi Kontekstual':
                return $questionCount > 0 ? round($totalScore / 8, 2) : 0;

            case 'Perilaku Kerja Tidak Produktif':
                return $questionCount > 0 ? round($totalScore / 5, 2) : 0;

            default:
                return $totalScore;
        }
    }
    /**
     * Calculate maximum possible score for a single question
     */
    private function calculateMaxScoreForQuestion(array $question): int
    {
        if (isset($question['options']) && is_array($question['options'])) {
            $maxScore = 0;
            foreach ($question['options'] as $option) {
                if (is_string($option)) {
                    if (preg_match('/\((\d+)\)/', $option, $matches)) {
                        $maxScore = max($maxScore, (int)$matches[1]);
                    }
                } elseif (is_array($option) && isset($option['value'])) {
                    $maxScore = max($maxScore, (int)$option['value']);
                }
            }
            return $maxScore > 0 ? $maxScore : 1;
        }

        return 1;
    }

    /**
     * Determine category based on score ranges
     */
    private function determineCategory(int $score, array $sectionData, string $subsectionSelect = ''): string
    {
        if (isset($sectionData['scoring']['ranges']) || isset($sectionData['scoring']['interpretation'])) {
            if (!isset($sectionData['scoring']['interpretation'][$subsectionSelect]))
                $ranges = isset($sectionData['scoring']['ranges']) ? $sectionData['scoring']['ranges'] : $sectionData['scoring']['interpretation'];
            else
                $ranges = $sectionData['scoring']['interpretation'][$subsectionSelect];

            foreach ($ranges as $range) {
                $scoreRange = isset($sectionData['scoring']['ranges']) ? $range['score'] : (isset($range['range']) ? $range['range'] : false);
                if ($scoreRange) {
                    if (strpos($scoreRange, '-') !== false) {
                        list($min, $max) = explode('-',   $scoreRange);
                        if ($score >= (int)$min && $score <= (int)$max) {
                            return $range['category'];
                        }
                    } elseif (strpos($scoreRange, '+') !== false) {
                        // Handle ranges like "13+"
                        $min = (int)str_replace('+', '',   $scoreRange);
                        if ($score >= $min) {
                            return $range['category'];
                        }
                    } else {
                        // Handle single values
                        if ($score == (int)  $scoreRange) {
                            return $range['category'];
                        }
                    }
                }
            }
        }
        return 'Perlu Perhatian';
    }

    /**
     * Get recommendation based on category
     */
    private function getRecommendation(int $score, array $sectionData): string
    {
        if (isset($sectionData['scoring']['recommendations'])) {
            foreach ($sectionData['scoring']['recommendations'] as $category => $recommendation) {
                if ($this->determineCategory($score, $sectionData) === $category) {
                    return $recommendation;
                }
            }
        }

        $category = $this->determineCategory($score, $sectionData);
        return $recommendations[$category] ?? 'Teruskan usaha untuk penambahbaikan.';
    }

    /**
     * Update or create score records for subsections
     */
    public function updateSubsectionScores(SurveyResponse $response, array $subsectionScores): void
    {
        // Clear existing subsection scores for this response
        SurveyScore::where('response_id', $response->id)
            ->where('section', 'like', $response->survey_id . '_subsection_%')
            ->delete();

        // Create new subsection scores
        foreach ($subsectionScores as $index => $subsection) {
            SurveyScore::create([
                'response_id' => $response->id,
                'section' => $response->survey_id . '_subsection_' . ($index + 1),
                'score' => $subsection['score'],
                'category' => $subsection['category'],
                'recommendation' => $subsection['recommendation']
            ]);
        }
    }
}

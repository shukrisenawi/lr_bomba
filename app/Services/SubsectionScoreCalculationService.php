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

        if ($sectionId === 'C') {
            return $this->calculateSectionBOverallScore($response, $sectionData);
        }

        if ($sectionId === 'K') {
            return [];
        }

        if ($sectionId === 'E') {
            return $this->calculateSectionDScores($response, $sectionData);
        } else if ($sectionId === 'H') {
            return $this->calculateBat12SectionGScores($response, $sectionData);
        }

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
                if ($sectionId === 'E') {
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
     * Calculate Section B overall score as a whole without subsections
     */
    private function calculateSectionBOverallScore(SurveyResponse $response, array $sectionData): array
    {
        $answers = $response->answers()->get()->keyBy('question_id');
        $totalScore = 0;
        $questionCount = 0;
        $maxPossibleScore = 0;

        // Calculate total score across all questions in all subsections
        foreach ($sectionData['subsections'] as $subsection) {
            if (!isset($subsection['questions']) || empty($subsection['questions'])) {
                continue;
            }

            foreach ($subsection['questions'] as $question) {
                $questionId = $question['id'];

                if ($answers->has($questionId) && $answers[$questionId]->score !== null) {
                    $totalScore += (int)$answers[$questionId]->score;
                    $questionCount++;
                }

                // Calculate max possible score for this question
                $maxScore = $this->calculateMaxScoreForQuestion($question);
                $maxPossibleScore += $maxScore;
            }
        }

        if ($questionCount > 0) {
            return [[
                'name' => 'Jumlah Skor Keseluruhan',
                'score' => $totalScore,
                'raw_score' => $totalScore,
                'max_possible' => $maxPossibleScore,
                'category' => '', // Empty category as requested
                'recommendation' => '', // Empty recommendation as categories not needed
                'question_count' => $questionCount
            ]];
        }

        return [];
    }

    /**
     * Calculate BAT12 Section G scores with specific formulas
     */
    private function calculateBat12SectionGScores(SurveyResponse $response, array $sectionData): array
    {
        $bat12Service = new \App\Services\Bat12ScoreCalculationService();
        $bat12Scores = $bat12Service->calculateBat12SectionGScores($response);

        $subsectionScores = [];

        // Create subsections for each BAT12 component
        $components = [
            'Keletihan' => 'Jumlah Skor Keletihan',
            'Jarak mental' => 'Jumlah Skor Jarak Mental',
            'Kemerosotan kognitif' => 'Jumlah Skor Kemerosotan Kognitif',
            'Kemerosotan emosi' => 'Jumlah Skor Kemerosotan Emosi',
            'Overall BAT12' => 'Jumlah Skor Keseluruhan BAT12'
        ];

        foreach ($components as $key => $name) {
            $score = $bat12Scores[$key];
            // $interpretation = $bat12Service->getBat12Interpretation($score);

            $category = $this->determineCategory($score, $sectionData, $key);

            $recommendation = $this->getRecommendation($score, $sectionData, $key);

            $subsectionScores[] = [
                'name' => $name,
                'score' => $score,
                'raw_score' => $score,
                'max_possible' => 5,
                'category' => $category,
                'recommendation' => $recommendation,
                'question_count' => $key === 'Overall BAT12' ? 23 : ($key === 'Keletihan' ? 8 : 5)
            ];
        }

        return $subsectionScores;
    }
    private function calculateSectionDScores(SurveyResponse $response, array $sectionData): array
    {
        $service = new \App\Services\SectionDScoreCalculationService();
        $scores = $service->calculateSectionDScores($response);

        $subsectionScores = [];

        // Create subsections for each BAT12 component
        $components = [
            'Prestasi Tugas' => 'Jumlah Skor Prestasi Tugas',
            'Prestasi Kontekstual' => 'Jumlah Skor Prestasi Konteksual',
            'Perilaku Kerja Tidak Produktif' => 'Jumlah Skor Perilaku Kerja Tidak Produktif',
            'Keseluruhan' => 'Jumlah Skor Keseluruhan'
        ];

        foreach ($components as $key => $name) {
            $score = $scores[$key];
            // $interpretation = $bat12Service->getBat12Interpretation($score);

            $category = $this->determineCategory($score, $sectionData, $key);

            $recommendation = $this->getRecommendation($score, $sectionData);

            $subsectionScores[] = [
                'name' => $name,
                'score' => $score,
                'raw_score' => $score,
                'max_possible' => 4,
                'category' => $category,
                'recommendation' => $recommendation,
                'question_count' => $key === 'Keseluruhan' ? 18 : ($key === 'Prestasi Tugas' ? 5 : ($key === 'Prestasi Kontekstual' ? 8 : 5))
            ];
        }

        return $subsectionScores;
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
    private function determineCategory(float $score, array $sectionData, string $subsectionSelect = ''): string
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

                        if ($score >= $min && $score <= $max) {
                            return $range['category'];
                        }
                    } elseif (strpos($scoreRange, '+') !== false) {
                        // Handle ranges like "13+"
                        $min = str_replace('+', '',   $scoreRange);
                        if ($score >= $min) {
                            return $range['category'];
                        }
                    } else {
                        // Handle single values
                        if ($score ==  $scoreRange) {
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
    private function getRecommendation(float $score, array $sectionData, string $subsectionSelect = ''): string
    {
        $categorySelect = $this->determineCategory($score, $sectionData, $subsectionSelect);
        if (isset($sectionData['scoring']['recommendations'])) {

            foreach ($sectionData['scoring']['recommendations'] as $category => $recommendation) {
                if ($subsectionSelect === '') {
                    if ($categorySelect == $category) {
                        return $recommendation;
                    }
                } else {
                    if ($subsectionSelect == $category) {
                        $categorySelect = $categorySelect;
                        return isset($recommendation[$categorySelect]) ? $recommendation[$categorySelect] : '';
                    }
                }
            }
        }
        $category = $this->determineCategory($score, $sectionData, $subsectionSelect);

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

        // Special handling for Section D overall score
        // if ($response->survey_id === 'D') {
        //     $overallScore = $this->calculateSectionDOverallScore($subsectionScores);

        //     // Add overall score as a separate entry
        //     SurveyScore::create([
        //         'response_id' => $response->id,
        //         'section' => $response->survey_id . '_overall',
        //         'score' => $overallScore,
        //         'category' => 'Keseluruhan',
        //         'recommendation' => 'JUMLAH SKOR KESELURUHAN: ' . $overallScore
        //     ]);
        // }
    }
}

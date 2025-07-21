<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

class SubsectionScoreCalculationService
{
    /**
     * @var array Cached score categories configuration
     */
    private $scoreCategories;

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
                $normalizedScore = $subsectionTotal;

                $category = $this->determineCategory($normalizedScore, $sectionData);
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
     * Load score categories from JSON configuration
     */
    private function loadScoreCategories(): array
    {
        if ($this->scoreCategories === null) {
            $configPath = config_path('score_categories.json');
            if (file_exists($configPath)) {
                $this->scoreCategories = json_decode(file_get_contents($configPath), true);
            } else {
                $this->scoreCategories = [];
            }
        }
        return $this->scoreCategories;
    }

    /**
     * Determine category based on score ranges from JSON configuration
     */
    private function determineCategory(int $score, array $sectionData): string
    {
        // First, check if section-specific ranges are provided in sectionData
        if (isset($sectionData['scoring']['ranges'])) {
            foreach ($sectionData['scoring']['ranges'] as $range) {
                if (strpos($range['score'], '-') !== false) {
                    list($min, $max) = explode('-', $range['score']);
                    if ($score >= (int)$min && $score <= (int)$max) {
                        return $range['category'];
                    }
                } elseif (strpos($range['score'], '+') !== false) {
                    $min = (int)str_replace('+', '', $range['score']);
                    if ($score >= $min) {
                        return $range['category'];
                    }
                } else {
                    if ($score == (int)$range['score']) {
                        return $range['category'];
                    }
                }
            }
        }

        // Use JSON configuration for categorization
        $categories = $this->loadScoreCategories();

        if (!empty($categories)) {
            $sectionId = $sectionData['id'] ?? null;

            // Check for section-specific categorization
            if ($sectionId && isset($categories['sections'][$sectionId])) {
                $sectionConfig = $categories['sections'][$sectionId];
                return $this->getCategoryFromRanges($score, $sectionConfig['ranges']);
            }

            // Use default categorization
            if (isset($categories['default'])) {
                return $this->getCategoryFromRanges($score, $categories['default']['ranges']);
            }
        }

        // Fallback default categorization (if JSON config is missing)
        if ($score >= 80) return 'Cemerlang';
        if ($score >= 60) return 'Baik';
        if ($score >= 40) return 'Sederhana';
        return 'Perlu Perhatian';
    }

    /**
     * Get category from score ranges
     */
    private function getCategoryFromRanges(int $score, array $ranges): string
    {
        foreach ($ranges as $range) {
            if ($score >= $range['min'] && $score <= $range['max']) {
                return $range['category'];
            }
        }

        return 'Perlu Perhatian'; // Default fallback
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

        // Default recommendations
        $recommendations = [
            'Cemerlang' => 'Tahniah atas keupayaan kerja yang cemerlang. Kekalkan prestasi ini.',
            'Baik' => 'Prestasi yang baik. Teruskan usaha untuk penambahbaikan berterusan.',
            'Sederhana' => 'Perlu penambahbaikan. Fokus pada aspek yang perlu ditingkatkan.',
            'Perlu Perhatian' => 'Perlu tindakan segera. Dapatkan bantuan profesional jika perlu.',
            'Sangat tinggi' => 'Prestasi sangat memuaskan. Teruskan usaha untuk kekalkan tahap ini.',
            'Tinggi' => 'Prestasi yang baik. Teruskan usaha untuk penambahbaikan.',
            'Rendah' => 'Perlu tindakan segera untuk meningkatkan prestasi.'
        ];

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

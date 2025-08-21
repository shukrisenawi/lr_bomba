<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SurveyQuestionMappingService
{
    protected $surveyData;
    protected $questionMap;

    public function __construct()
    {
        $this->loadSurveyData();
        $this->buildQuestionMap();
    }

    protected function loadSurveyData()
    {
        $jsonPath = storage_path('app/survey/1st_draft.json');
        if (file_exists($jsonPath)) {
            $this->surveyData = json_decode(file_get_contents($jsonPath), true);
        }
    }

    protected function buildQuestionMap()
    {
        $this->questionMap = [];

        if (!isset($this->surveyData['sections'])) {
            return;
        }

        foreach ($this->surveyData['sections'] as $section) {
            $sectionId = $section['id'] ?? 'unknown';
            $sectionTitle = $section['title_BM'] ?? $section['title_BI'] ?? 'Section ' . $sectionId;

            // Handle sections with subsections
            if (isset($section['subsections'])) {
                foreach ($section['subsections'] as $subsection) {
                    $subsectionName = $subsection['name'] ?? 'General';

                    if (isset($subsection['questions'])) {
                        foreach ($subsection['questions'] as $question) {
                            $questionId = $question['id'] ?? uniqid('q_');
                            $questionText = $question['text'] ?? 'No question text provided';
                            $questionType = $question['type'] ?? 'text';

                            $this->questionMap[$questionId] = [
                                'section_id' => $sectionId,
                                'section_title' => $sectionTitle,
                                'subsection_name' => $subsectionName,
                                'question_text' => $questionText,
                                'question_type' => $questionType,
                                'full_context' => "Bahagian {$sectionId}: {$sectionTitle} - {$subsectionName} - Soalan {$questionId}: {$questionText}"
                            ];
                        }
                    }
                }
            }

            // Handle sections with direct questions
            if (isset($section['questions'])) {
                foreach ($section['questions'] as $question) {
                    $questionId = $question['id'] ?? uniqid('q_');
                    $questionText = $question['text'] ?? 'No question text provided';
                    $questionType = $question['type'] ?? 'text';

                    $this->questionMap[$questionId] = [
                        'section_id' => $sectionId,
                        'section_title' => $sectionTitle,
                        'subsection_name' => null,
                        'question_text' => $questionText,
                        'question_type' => $questionType,
                        'full_context' => "Bahagian {$sectionId}: {$sectionTitle} - Soalan {$questionId}: {$questionText}"
                    ];
                }
            }
        }
    }

    public function getQuestionContext($questionId)
    {
        return $this->questionMap[$questionId] ?? [
            'section_id' => null,
            'section_title' => 'Unknown Section',
            'subsection_name' => null,
            'question_text' => 'Question text not found',
            'question_type' => 'text',
            'full_context' => "Soalan #{$questionId}"
        ];
    }

    public function getAllQuestionContexts()
    {
        return $this->questionMap;
    }

    /**
     * Get formatted question text for display (extracted from full context)
     * 
     * @param string $questionId
     * @return string
     */
    public function getFormattedQuestionText($questionId)
    {
        $context = $this->getQuestionContext($questionId);

        if (isset($context['full_context'])) {
            // Extract just the "Soalan X: ..." part
            $pattern = '/Soalan\s+[A-Z]?\d+\s*:\s*(.+)$/i';
            if (preg_match($pattern, $context['full_context'], $matches)) {
                return trim($matches[1]);
            }
        }

        return $context['question_text'] ?? 'Question not available';
    }
}

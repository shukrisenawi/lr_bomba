<?php

if (!function_exists('getOptionText')) {
    /**
     * Extract the display text from radio button options
     *
     * @param array $question The question array from survey JSON
     * @param string $storedAnswer The stored answer value
     * @return string The display text for the option
     */
    function getOptionText($question, $storedAnswer)
    {
        if (!isset($question['options']) || !is_array($question['options'])) {
            return $storedAnswer;
        }

        // Find the matching option text
        foreach ($question['options'] as $option) {
            if ($option === $storedAnswer) {
                // Return the full option text as-is since it already contains the display text
                return $option;
            }
        }

        return $storedAnswer;
    }
}

if (!function_exists('getDisplayTextForAnswer')) {
    /**
     * Get the display text for a survey answer based on question type
     *
     * @param array $question The question array from survey JSON
     * @param string $storedAnswer The stored answer value
     * @return string The display text for the answer
     */
    function getDisplayTextForAnswer($question, $storedAnswer)
    {
        if (empty($storedAnswer)) {
            return 'Tiada jawapan';
        }

        $type = $question['type'] ?? 'text';

        switch ($type) {
            case 'single_choice':
            case 'scale':
                return getOptionText($question, $storedAnswer);

            case 'multiple_choice':
                if (is_array($storedAnswer)) {
                    $displayTexts = [];
                    foreach ($storedAnswer as $answer) {
                        $displayTexts[] = getOptionText($question, $answer);
                    }
                    return implode(', ', $displayTexts);
                }
                return getOptionText($question, $storedAnswer);

            default:
                return $storedAnswer;
        }
    }
}

if (!function_exists('calculate_section_score')) {
    /**
     * Calculate section score based on answers
     *
     * @param string $section Section identifier
     * @param array $answers Array of survey answers
     * @return int Calculated score
     */
    function calculate_section_score($section, $answers)
    {
        // Placeholder implementation - to be customized per section
        return 0;
    }
}

if (!function_exists('find_question_by_id')) {
    /**
     * Find a question by ID within nested sections and subsections
     *
     * @param array $sectionData The section data containing questions and subsections
     * @param string|int $questionId The question ID to find
     * @return array|null The question data if found, null otherwise
     */
    function find_question_by_id($sectionData, $questionId)
    {
        // First, check regular questions in the section
        if (isset($sectionData['questions']) && is_array($sectionData['questions'])) {
            foreach ($sectionData['questions'] as $question) {
                if (isset($question['id']) && $question['id'] == $questionId) {
                    return $question;
                }
            }
        }

        // Then, check questions within subsections
        if (isset($sectionData['subsections']) && is_array($sectionData['subsections'])) {
            foreach ($sectionData['subsections'] as $subsection) {
                if (isset($subsection['questions']) && is_array($subsection['questions'])) {
                    foreach ($subsection['questions'] as $question) {
                        if (isset($question['id']) && $question['id'] == $questionId) {
                            return $question;
                        }
                    }
                }
            }
        }

        return null;
    }
}

if (!function_exists('get_all_questions_from_section')) {
    /**
     * Get all questions from a section, including those in subsections
     *
     * @param array $sectionData The section data
     * @return array Array of all questions in the section
     */
    function get_all_questions_from_section($sectionData)
    {
        $questions = [];

        // Add regular questions
        if (isset($sectionData['questions']) && is_array($sectionData['questions'])) {
            foreach ($sectionData['questions'] as $question) {
                $questions[] = $question;
            }
        }

        // Add questions from subsections
        if (isset($sectionData['subsections']) && is_array($sectionData['subsections'])) {
            foreach ($sectionData['subsections'] as $subsection) {
                if (isset($subsection['questions']) && is_array($subsection['questions'])) {
                    foreach ($subsection['questions'] as $question) {
                        // Add subsection context to question
                        $question['subsection_name'] = $subsection['name'] ?? '';
                        $questions[] = $question;
                    }
                }
            }
        }

        return $questions;
    }
}

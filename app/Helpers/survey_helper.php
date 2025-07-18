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

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

if (!function_exists('get_radio_button_image_score')) {
    /**
     * Calculate score for radio_button_image type questions
     * Extracts score from the selected option's value key
     *
     * @param array $question The question array from survey JSON
     * @param string $selectedAnswer The selected answer value
     * @return int The calculated score based on the option's value
     */
    function get_radio_button_image_score($question, $selectedAnswer)
    {
        if (!isset($question['type']) || $question['type'] !== 'radio_button_image') {
            return 0;
        }

        if (!isset($question['options']) || !is_array($question['options'])) {
            return 0;
        }

        // Find the matching option and extract its value as score
        foreach ($question['options'] as $option) {
            if (isset($option['value']) && isset($option['image'])) {
                // For radio_button_image, the value is the score
                if ($option['value'] == $selectedAnswer) {
                    return (int)$option['value'];
                }
            }
        }

        return 0;
    }
}

if (!function_exists('get_video_image_score')) {
    /**
     * Calculate score for videoImage type questions
     * For videoImage, score is typically based on number of files uploaded
     *
     * @param array $question The question array from survey JSON
     * @param string $answer The answer containing uploaded file information
     * @return int The calculated score based on upload count
     */
    function get_video_image_score($question, $answer)
    {
        if (!isset($question['type']) || $question['type'] !== 'videoImage') {
            return 0;
        }

        // Decode the JSON answer
        $answerData = json_decode($answer, true);
        if (!$answerData || !isset($answerData['upload_count'])) {
            return 0;
        }

        // Score based on number of uploads (can be customized)
        $uploadCount = $answerData['upload_count'];
        $limit = $question['limit'] ?? 5;

        // Score is proportional to uploads (max score when limit is reached)
        return min($uploadCount, $limit);
    }
}

if (!function_exists('get_select_box_image_score')) {
    /**
     * Calculate score for select_box_image type questions
     * Extracts score from the selected option's value key (similar to radio_button_image)
     *
     * @param array $question The question array from survey JSON
     * @param string $selectedAnswer The selected answer value
     * @return int The calculated score based on the option's value
     */
    function get_select_box_image_score($question, $selectedAnswer)
    {
        if (!isset($question['type']) || $question['type'] !== 'select_box_image') {
            return 0;
        }

        if (!isset($question['options']) || !is_array($question['options'])) {
            return 0;
        }

        // Find the matching option and extract its value as score
        foreach ($question['options'] as $option) {
            if (isset($option['value']) && isset($option['image'])) {
                // For select_box_image, the value is the score
                if ($option['value'] == $selectedAnswer) {
                    return (int)$option['value'];
                }
            }
        }

        return 0;
    }
}

if (!function_exists('calculate_question_score')) {
    /**
     * Calculate score for a specific question based on its type
     *
     * @param array $question The question array from survey JSON
     * @param string|array $answer The user's answer
     * @return int The calculated score
     */
    function calculate_question_score($question, $answer)
    {
        if (empty($answer)) {
            return 0;
        }

        $type = $question['type'] ?? 'text';

        switch ($type) {
            case 'radio_button_image':
                return get_radio_button_image_score($question, $answer);

            case 'select_box_image':
                return get_select_box_image_score($question, $answer);

            case 'videoImage':
                return get_video_image_score($question, $answer);

            case 'single_choice':
                // Extract score from options like "Text (score)"
                if (isset($question['options']) && is_array($question['options'])) {
                    foreach ($question['options'] as $option) {
                        if (is_string($option) && strpos($option, '(') !== false && strpos($option, ')') !== false) {
                            // Extract the score from format "Text (score)"
                            preg_match('/\((\d+)\)$/', $option, $matches);
                            if (isset($matches[1]) && $option === $answer) {
                                return (int)$matches[1];
                            }
                        }
                    }
                }
                return 0;

            case 'scale':
                // For scale questions, the answer itself is the score
                return is_numeric($answer) ? (int)$answer : 0;

            default:
                return 0;
        }
    }
}

if (!function_exists('calculate_section_score_with_questions')) {
    /**
     * Calculate section score based on answers and question definitions
     *
     * @param array $sectionData The section data containing questions
     * @param array $answers Array of survey answers
     * @return int Calculated score
     */
    function calculate_section_score_with_questions($sectionData, $answers)
    {
        $totalScore = 0;

        // Get all questions from the section
        $questions = get_all_questions_from_section($sectionData);

        foreach ($questions as $question) {
            $questionId = $question['id'] ?? '';
            if (isset($answers[$questionId])) {
                $score = calculate_question_score($question, $answers[$questionId]);
                $totalScore += $score;
            }
        }

        return $totalScore;
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

if (!function_exists('find_question_by_id_in_survey')) {
    /**
     * Find a question by ID within the entire survey structure
     *
     * @param array $surveyData The complete survey data
     * @param string $questionId The question ID to find
     * @return array|null The question data if found, null otherwise
     */
    function find_question_by_id_in_survey($surveyData, $questionId)
    {
        if (!isset($surveyData['sections']) || !is_array($surveyData['sections'])) {
            return null;
        }

        foreach ($surveyData['sections'] as $section) {
            $question = find_question_by_id($section, $questionId);
            if ($question !== null) {
                return $question;
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

if (!function_exists('get_options_from_referer')) {
    /**
     * Get dynamic options from a referer question's answers
     *
     * @param array $surveyData The complete survey data
     * @param string $refererQuestionId The question ID to get options from
     * @param array $answers Array of survey answers
     * @return array Array of options for the current question
     */
    function get_options_from_referer($surveyData, $refererQuestionId, $answers)
    {
        // Find the referer question
        $refererQuestion = find_question_by_id_in_survey($surveyData, $refererQuestionId);

        if (!$refererQuestion) {
            return [];
        }

        // Get the answer from the referer question
        $refererAnswer = $answers[$refererQuestionId] ?? '';

        if (empty($refererAnswer)) {
            return [];
        }

        // Handle different types of answers
        $options = [];

        // If the referer question is multiText, split the answer into individual options
        if ($refererQuestion['type'] === 'multiText') {
            if (is_array($refererAnswer)) {
                $options = $refererAnswer;
            } else {
                // Handle string answers (split by new lines or commas)
                // $options = preg_split('/[\n,]+/', $refererAnswer);
                $options = json_decode($refererAnswer);

                $options = collect($options)->map(function ($item) {
                    return collect($item)->values()->first(); // Ambil value pertama
                })->toArray();

                $options = array_map('trim', $options);
                $options = array_filter($options);
            }
        } else {
            // For single choice or other types, use the answer as a single option
            $options = [$refererAnswer];
        }

        return $options;
    }
}

if (!function_exists('get_referer_options')) {
    /**
     * Get options for a question that uses optionsReferer
     *
     * @param array $question The current question
     * @param array $surveyData The complete survey data
     * @param array $answers Array of survey answers
     * @return array Array of options
     */
    function get_referer_options($question, $surveyData, $answers)
    {
        if (!isset($question['optionsReferer'])) {
            return $question['options'] ?? [];
        }

        return get_options_from_referer($surveyData, $question['optionsReferer'], $answers);
    }
}

if (!function_exists('get_multi_text_answers')) {
    /**
     * Get answers from multiText questions as array
     *
     * @param string $answer The stored answer from multiText question
     * @return array Array of individual answers
     */
    function get_multi_text_answers($answer)
    {
        if (empty($answer)) {
            return [];
        }

        if (is_array($answer)) {
            return $answer;
        }

        // Handle string answers
        $answers = preg_split('/[\n,]+/', $answer);
        $answers = array_map('trim', $answers);
        $answers = array_filter($answers);

        return array_values($answers);
    }
}

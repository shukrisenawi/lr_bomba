<?php

if (!function_exists('extractQuestionText')) {
    /**
     * Extract just the question part from the full context string
     * 
     * @param string $fullContext The full context string
     * @return string The extracted question text
     */
    function extractQuestionText($fullContext)
    {
        // Pattern to match "Soalan X: " followed by the actual question
        $pattern = '/Soalan\s+[A-Z]?\d+\s*:\s*(.+)$/i';
        
        if (preg_match($pattern, $fullContext, $matches)) {
            return trim($matches[1]);
        }
        
        // Fallback: if pattern doesn't match, return the original
        return $fullContext;
    }
}

if (!function_exists('formatQuestionDisplay')) {
    /**
     * Format question display to show only the question part
     * 
     * @param array $questionContext The question context array
     * @return string Formatted question text
     */
    function formatQuestionDisplay($questionContext)
    {
        if (isset($questionContext['full_context'])) {
            return extractQuestionText($questionContext['full_context']);
        }
        
        return $questionContext['question_text'] ?? 'Question not available';
    }
}

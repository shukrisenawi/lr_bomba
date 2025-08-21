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

if (!function_exists('displayVideoImageAnswer')) {
    /**
     * Display videoImage answer with proper video and image previews
     *
     * @param string $answer The JSON answer containing file information
     * @return string HTML for displaying video/image files
     */
    function displayVideoImageAnswer($answer)
    {
        $answerData = json_decode($answer, true);

        if (!$answerData || !isset($answerData['files']) || empty($answerData['files'])) {
            return '<span class="text-gray-500 italic">Tiada fail dimuat naik</span>';
        }

        $html = '<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3" onclick="event.stopPropagation();">';

        foreach ($answerData['files'] as $file) {
            $html .= '<div class="relative bg-gray-50 rounded-lg p-3 border" onclick="event.stopPropagation();">';

            if (str_contains($file['mime_type'], 'image')) {
                // Display image with lightbox functionality - prevent accordion collapse
                $html .= '<a href="' . $file['url'] . '" target="_blank" class="block" onclick="event.stopPropagation();">';
                $html .= '<img src="' . $file['url'] . '" alt="' . htmlspecialchars($file['original_name']) . '" ';
                $html .= 'class="w-full h-32 object-cover rounded-lg hover:opacity-80 transition-opacity" onclick="event.stopPropagation();">';
                $html .= '</a>';
            } else if (str_contains($file['mime_type'], 'video')) {
                // Display video player - prevent accordion collapse
                $html .= '<video controls class="w-full h-32 rounded-lg bg-black" onclick="event.stopPropagation();">';
                $html .= '<source src="' . $file['url'] . '" type="' . $file['mime_type'] . '">';
                $html .= 'Browser anda tidak menyokong video player.';
                $html .= '</video>';
            } else {
                // Display file icon for other types
                $html .= '<div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">';
                $html .= '<i class="fas fa-file text-3xl text-gray-500"></i>';
                $html .= '</div>';
            }

            // File info
            $html .= '<p class="text-xs text-gray-600 mt-2 truncate" title="' . htmlspecialchars($file['original_name']) . '">';
            $html .= htmlspecialchars($file['original_name']);
            $html .= '</p>';
            $html .= '<p class="text-xs text-gray-400">';
            $html .= number_format($file['size'] / 1024, 1) . ' KB';
            $html .= '</p>';

            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '<p class="text-sm text-gray-600 mt-2">';
        $html .= 'Jumlah fail: ' . count($answerData['files']);
        $html .= '</p>';

        return $html;
    }
}

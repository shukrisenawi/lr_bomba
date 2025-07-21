<?php

if (!function_exists('getFullSectionTitle')) {
    /**
     * Get the full section title based on section ID from JSON configuration
     * 
     * @param string $sectionId The section ID (A, B, C, etc.)
     * @return string The full section title
     */
    function getFullSectionTitle($sectionId)
    {
        $jsonPath = config_path('section_titles.json');
        
        if (file_exists($jsonPath)) {
            $sectionTitles = json_decode(file_get_contents($jsonPath), true);
            
            if (is_array($sectionTitles) && isset($sectionTitles[$sectionId])) {
                return $sectionTitles[$sectionId];
            }
        }
        
        // Fallback to default if JSON file doesn't exist or section not found
        return "Bahagian {$sectionId}";
    }
}

if (!function_exists('getSectionTitleFromSurvey')) {
    /**
     * Get section title from survey JSON data
     * 
     * @param string $sectionId The section ID
     * @return string The full section title
     */
    function getSectionTitleFromSurvey($sectionId)
    {
        $jsonPath = storage_path('app/survey/1st_draft.json');
        
        if (file_exists($jsonPath)) {
            $surveyData = json_decode(file_get_contents($jsonPath), true);
            
            if (isset($surveyData['sections'])) {
                foreach ($surveyData['sections'] as $section) {
                    if (isset($section['id']) && $section['id'] === $sectionId) {
                        return $section['title_BM'] ?? "Bahagian {$sectionId}";
                    }
                }
            }
        }
        
        return getFullSectionTitle($sectionId);
    }
}

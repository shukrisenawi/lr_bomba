<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get survey data
        $surveyPath = storage_path('app/survey/1st_draft.json');
        if (!File::exists($surveyPath)) {
            return;
        }

        $surveyData = json_decode(File::get($surveyPath), true);

        // Process each section and question
        foreach ($surveyData['sections'] as $section) {
            foreach ($section['questions'] as $question) {
                if ($question['type'] === 'single_choice') {
                    $this->fixRadioButtonAnswers($question);
                }
            }
        }
    }

    /**
     * Fix radio button answers for a specific question
     */
    private function fixRadioButtonAnswers($question)
    {
        foreach ($question['options'] as $option) {
            $optionText = '';
            $optionValue = '';
            $score = null;

            if (is_array($option)) {
                $optionText = $option['text'] ?? '';
                $optionValue = $option['value'] ?? '';

                // Extract score from parentheses
                if (isset($option['text']) && preg_match('/\((\d+)\)/', $option['text'], $matches)) {
                    $score = (int)$matches[1];
                }
            } else {
                $optionText = $option;
                $optionValue = $option;

                // Extract score from parentheses
                if (preg_match('/\((\d+)\)/', $option, $matches)) {
                    $score = (int)$matches[1];
                }
            }

            // Update existing answers that match the value
            DB::table('survey_answers')
                ->where('question_id', $question['id'])
                ->where('answer', $optionValue) // Current stored value
                ->update([
                    'answer' => $optionText,
                    'value' => $optionValue,
                    'score' => $score,
                    'updated_at' => now()
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as it fixes data
    }
};

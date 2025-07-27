<?php

/**
 * Simple diagnostic for Section G (BAT12) scoring issues
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Use Laravel's database connection
use Illuminate\Support\Facades\DB;

echo "=== SECTION G (BAT12) DIAGNOSTIC ===\n\n";

// Check database connection and get basic stats
try {
    // Get total Section G responses
    $totalResponses = DB::table('survey_responses')
        ->where('survey_id', 'G')
        ->count();

    echo "Total Section G responses: " . $totalResponses . "\n\n";

    // Check survey scores for Section G
    $sectionGScores = DB::table('survey_scores')
        ->where('section', 'like', '%G%')
        ->get();

    echo "Total Section G scores: " . $sectionGScores->count() . "\n";

    $zeroScores = $sectionGScores->where('score', 0.00)->count();
    echo "0.00 scores: " . $zeroScores . "\n\n";

    // Get detailed breakdown
    if ($sectionGScores->count() > 0) {
        echo "=== DETAILED BREAKDOWN ===\n";

        // Group by response
        $scoresByResponse = DB::table('survey_scores')
            ->where('section', 'like', '%G%')
            ->select('response_id', 'section', 'score', 'category')
            ->orderBy('response_id')
            ->get()
            ->groupBy('response_id');

        foreach ($scoresByResponse as $responseId => $scores) {
            echo "Response ID: {$responseId}\n";

            // Get response details
            $response = DB::table('survey_responses')
                ->where('id', $responseId)
                ->first();

            if ($response) {
                echo "  Respondent ID: {$response->respondent_id}\n";

                // Get answers for this response
                $answers = DB::table('survey_answers')
                    ->where('response_id', $responseId)
                    ->get();

                echo "  Total answers: " . $answers->count() . "\n";

                // Check specific BAT12 questions
                $bat12Questions = [
                    'kelelahan_fisik',
                    'kelelahan_mental',
                    'kelelahan_emosional',
                    'jarak_mental_kerja',
                    'kemerosotan_memori',
                    'kemerosotan_emosi_positif'
                ];

                $answered = 0;
                $totalRaw = 0;

                foreach ($bat12Questions as $q) {
                    $answer = $answers->firstWhere('question_id', $q);
                    if ($answer && $answer->score !== null) {
                        $answered++;
                        $totalRaw += $answer->score;
                    }
                }

                echo "  BAT12 questions answered: {$answered}/" . count($bat12Questions) . "\n";
                echo "  Total raw score: {$totalRaw}\n";
            }

            echo "  Scores:\n";
            foreach ($scores as $score) {
                echo "    {$score->section}: {$score->score} ({$score->category})\n";
            }
            echo "\n";
        }
    }

    // Check for missing question mappings
    echo "=== QUESTION MAPPING ANALYSIS ===\n";

    // Get all unique question IDs from survey_answers
    $existingQuestions = DB::table('survey_answers')
        ->select('question_id')
        ->distinct()
        ->pluck('question_id')
        ->toArray();

    // Expected BAT12 questions
    $expectedBat12Questions = [
        'kelelahan_fisik',
        'kelelahan_mental',
        'kelelahan_emosional',
        'kelelahan_motivasi',
        'kelelahan_aktivitas',
        'kelelahan_konsentrasi',
        'kelelahan_memori',
        'kelelahan_tidur',
        'jarak_mental_kerja',
        'jarak_mental_tugas',
        'jarak_mental_rekan',
        'jarak_mental_pimpinan',
        'jarak_mental_organisasi',
        'kemerosotan_memori',
        'kemerosotan_konsentrasi',
        'kemerosotan_perhatian',
        'kemerosotan_keputusan',
        'kemerosotan_pemecahan_masalah',
        'kemerosotan_emosi_positif',
        'kemerosotan_emosi_negatif',
        'kemerosotan_kontrol_emosi',
        'kemerosotan_empati',
        'kemerosotan_kesadaran_emosi'
    ];

    $found = [];
    $missing = [];

    foreach ($expectedBat12Questions as $q) {
        if (in_array($q, $existingQuestions)) {
            $found[] = $q;
        } else {
            $missing[] = $q;
        }
    }

    echo "Found BAT12 questions: " . count($found) . "\n";
    echo "Missing BAT12 questions: " . count($missing) . "\n";

    if (!empty($missing)) {
        echo "Missing questions:\n";
        foreach (array_chunk($missing, 5) as $chunk) {
            echo "  " . implode(', ', $chunk) . "\n";
        }
    }

    echo "\n=== RECOMMENDATIONS ===\n";
    echo "1. Check if all BAT12 questions are properly mapped in survey configuration\n";
    echo "2. Ensure survey_answers table contains all required BAT12 questions\n";
    echo "3. Verify score values are not null (should be 1-5)\n";
    echo "4. Run score recalculation after fixing missing data\n";
    echo "5. Check if the scoring calculation is working correctly with valid input\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Please check your database connection and configuration.\n";
}

<?php

/**
 * Diagnostic script to check Section G (BAT12) scoring issues
 * Run this script to identify why scores are showing 0.00
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

// Setup database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'your_database_name',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "=== SECTION G (BAT12) DIAGNOSTIC REPORT ===\n\n";

// Check survey responses with Section G
$responses = SurveyResponse::where('survey_id', 'G')->get();
echo "Total Section G responses: " . $responses->count() . "\n\n";

// BAT12 question mappings
$bat12Questions = [
    'fatigue' => [
        'kelelahan_fisik',
        'kelelahan_mental',
        'kelelahan_emosional',
        'kelelahan_motivasi',
        'kelelahan_aktivitas',
        'kelelahan_konsentrasi',
        'kelelahan_memori',
        'kelelahan_tidur'
    ],
    'mental_distance' => [
        'jarak_mental_kerja',
        'jarak_mental_tugas',
        'jarak_mental_rekan',
        'jarak_mental_pimpinan',
        'jarak_mental_organisasi'
    ],
    'cognitive_decline' => [
        'kemerosotan_memori',
        'kemerosotan_konsentrasi',
        'kemerosotan_perhatian',
        'kemerosotan_keputusan',
        'kemerosotan_pemecahan_masalah'
    ],
    'emotional_decline' => [
        'kemerosotan_emosi_positif',
        'kemerosotan_emosi_negatif',
        'kemerosotan_kontrol_emosi',
        'kemerosotan_empati',
        'kemerosotan_kesadaran_emosi'
    ]
];

foreach ($responses as $response) {
    echo "Response ID: {$response->id}\n";
    echo "Respondent ID: {$response->respondent_id}\n";

    // Get all answers for this response
    $answers = SurveyAnswer::where('response_id', $response->id)->get();
    echo "Total answers: " . $answers->count() . "\n";

    // Check BAT12 specific answers
    $bat12Answers = [];
    foreach ($bat12Questions as $category => $questions) {
        $categoryAnswers = [];
        foreach ($questions as $question) {
            $answer = $answers->firstWhere('question_id', $question);
            if ($answer) {
                $categoryAnswers[$question] = [
                    'score' => $answer->score,
                    'value' => $answer->value
                ];
            } else {
                $categoryAnswers[$question] = [
                    'score' => null,
                    'value' => null,
                    'missing' => true
                ];
            }
        }
        $bat12Answers[$category] = $categoryAnswers;
    }

    // Calculate raw scores
    echo "BAT12 Raw Scores:\n";
    foreach ($bat12Answers as $category => $answers) {
        $rawScore = array_sum(array_column($answers, 'score'));
        $validAnswers = count(array_filter($answers, fn($a) => $a['score'] !== null));
        echo "  {$category}: {$rawScore}/{$validAnswers} questions answered\n";
    }

    // Check survey_scores entries
    $scores = SurveyScore::where('response_id', $response->id)
        ->where('section', 'like', '%G%')
        ->get();

    echo "Survey Scores for Section G:\n";
    foreach ($scores as $score) {
        echo "  Section: {$score->section}, Score: {$score->score}, Category: {$score->category}\n";
    }

    echo "----------------------------------------\n\n";
}

// Summary statistics
echo "\n=== SUMMARY STATISTICS ===\n";
$zeroScores = SurveyScore::where('section', 'like', '%G%')
    ->where('score', 0.00)
    ->count();
echo "Total 0.00 scores in Section G: {$zeroScores}\n";

$totalScores = SurveyScore::where('section', 'like', '%G%')->count();
echo "Total Section G scores: {$totalScores}\n";

if ($totalScores > 0) {
    $percentage = round(($zeroScores / $totalScores) * 100, 2);
    echo "Percentage of 0.00 scores: {$percentage}%\n";
}

// Check for missing BAT12 questions
echo "\n=== MISSING BAT12 QUESTIONS CHECK ===\n";
$allQuestions = array_merge(...array_values($bat12Questions));
$missingQuestions = [];

foreach ($allQuestions as $question) {
    $exists = SurveyAnswer::where('question_id', $question)->exists();
    if (!$exists) {
        $missingQuestions[] = $question;
    }
}

if (!empty($missingQuestions)) {
    echo "Missing BAT12 questions in survey_answers:\n";
    foreach ($missingQuestions as $q) {
        echo "  - {$q}\n";
    }
} else {
    echo "All BAT12 questions found in survey_answers\n";
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Check if BAT12 questions are properly mapped in your survey configuration\n";
echo "2. Verify that all BAT12 questions have valid score values (1-5)\n";
echo "3. Ensure survey_answers table has all required BAT12 question entries\n";
echo "4. Review the scoring calculation logic in Bat12ScoreCalculationService\n";

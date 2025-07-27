<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;

// Run the diagnostic
echo "=== SECTION G (BAT12) DIAGNOSTIC ===\n\n";

// Check survey responses with Section G
$responses = SurveyResponse::where('survey_id', 'G')->get();
echo "Total Section G responses: " . $responses->count() . "\n\n";

// Check survey scores for Section G
$sectionGScores = SurveyScore::where('section', 'like', '%G%')->get();
echo "Total Section G scores: " . $sectionGScores->count() . "\n";
echo "0.00 scores: " . $sectionGScores->where('score', 0.00)->count() . "\n\n";

// Check first few responses
$responses = SurveyResponse::where('survey_id', 'G')->limit(5)->get();
foreach ($responses as $response) {
    echo "Response ID: {$response->id}\n";
    echo "Respondent ID: {$response->respondent_id}\n";

    // Get all answers for this response
    $answers = SurveyAnswer::where('response_id', $response->id)->get();
    echo "Total answers: " . $answers->count() . "\n";

    // Check BAT12 specific questions
    $bat12Questions = [
        'kelelahan_fisik',
        'kelelahan_mental',
        'kelelahan_emosional',
        'jarak_mental_kerja',
        'kemerosotan_memori',
        'kemerosotan_emosi_positif'
    ];

    $answeredCount = 0;
    $totalScore = 0;

    foreach ($bat12Questions as $q) {
        $answer = $answers->firstWhere('question_id', $q);
        if ($answer && $answer->score !== null) {
            $answeredCount++;
            $totalScore += $answer->score;
            echo "  {$q}: score={$answer->score}\n";
        } else {
            echo "  {$q}: MISSING or NULL\n";
        }
    }

    echo "  BAT12 questions answered: {$answeredCount}/" . count($bat12Questions) . "\n";
    echo "  Total raw score: {$totalScore}\n";

    // Check survey_scores entries
    $scores = SurveyScore::where('response_id', $response->id)
        ->where('section', 'like', '%G%')
        ->get();

    echo "  Survey Scores:\n";
    foreach ($scores as $score) {
        echo "    {$score->section}: {$score->score} ({$score->category})\n";
    }

    echo "----------------------------------------\n";
}

// Summary
echo "\n=== SUMMARY ===\n";
$zeroScores = SurveyScore::where('section', 'like', '%G%')
    ->where('score', 0.00)
    ->count();
$totalScores = SurveyScore::where('section', 'like', '%G%')->count();

if ($totalScores > 0) {
    $percentage = round(($zeroScores / $totalScores) * 100, 2);
    echo "Percentage of 0.00 scores: {$percentage}%\n";
}

// Check for missing question mappings
echo "\n=== QUESTION MAPPING CHECK ===\n";
$allBat12Questions = [
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

$foundQuestions = [];
$missingQuestions = [];

foreach ($allBat12Questions as $q) {
    $exists = SurveyAnswer::where('question_id', $q)->exists();
    if ($exists) {
        $foundQuestions[] = $q;
    } else {
        $missingQuestions[] = $q;
    }
}

echo "Found BAT12 questions: " . count($foundQuestions) . "\n";
echo "Missing BAT12 questions: " . count($missingQuestions) . "\n";

if (!empty($missingQuestions)) {
    echo "Missing questions:\n";
    foreach (array_chunk($missingQuestions, 5) as $chunk) {
        echo "  " . implode(', ', $chunk) . "\n";
    }
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Ensure all BAT12 questions are properly mapped in survey configuration\n";
echo "2. Check that survey_answers table contains all required BAT12 questions\n";
echo "3. Verify score values are not null (should be 1-5)\n";
echo "4. Run score recalculation after fixing missing data\n";

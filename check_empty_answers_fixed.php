<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\SurveyAnswer;

// Check for empty answers
$emptyAnswers = SurveyAnswer::where(function ($query) {
    $query->whereNull('answer')
        ->orWhere('answer', '')
        ->orWhere('answer', ' ');
})->with(['response' => function ($query) {
    $query->with('user');
}])->get();

echo "=== DIAGNOSTIK JAWAPAN KOSONG ===\n";
echo "Jumlah jawapan kosong: " . $emptyAnswers->count() . "\n\n";

if ($emptyAnswers->count() > 0) {
    echo "Senarai jawapan kosong:\n";
    foreach ($emptyAnswers as $answer) {
        echo "- ID: " . $answer->id . "\n";
        echo "- Soalan ID: " . $answer->question_id . "\n";
        echo "- Pengguna: " . ($answer->response->user->name ?? 'Unknown') . "\n";
        echo "- Seksyen: " . $answer->response->survey_id . "\n";
        echo "- Nilai: '" . addslashes($answer->answer) . "'\n";
        echo "-------------------\n";
    }
} else {
    echo "Tiada jawapan kosong ditemui.\n";
}

// Check for all answers to verify data integrity
$allAnswers = SurveyAnswer::with(['response' => function ($query) {
    $query->with('user');
}])->get();

echo "\n=== RINGKASAN KESELURUHAN ===\n";
echo "Jumlah jawapan keseluruhan: " . $allAnswers->count() . "\n";

$validAnswers = $allAnswers->filter(function ($answer) {
    return !empty(trim($answer->answer));
});

echo "Jumlah jawapan sah: " . $validAnswers->count() . "\n";
echo "Jumlah jawapan kosong: " . ($allAnswers->count() - $validAnswers->count()) . "\n";

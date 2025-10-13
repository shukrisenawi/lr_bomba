<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "=== DIAGNOSIS DATA SURVEY ===\n\n";

    // 1. Cek semua users dengan role user
    echo "1. Users dengan role 'user':\n";
    $users = DB::table('users')->where('role', 'user')->get();
    echo "Total users: " . $users->count() . "\n";

    foreach ($users as $user) {
        echo "- {$user->name} ({$user->email})\n";
    }

    echo "\n";

    // 2. Cek survey responses untuk setiap section
    $sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

    foreach ($sections as $section) {
        echo "2. Section {$section} - Survey Responses:\n";

        $responses = DB::table('survey_responses')
            ->where('survey_id', $section)
            ->get();

        echo "Total responses: " . $responses->count() . "\n";

        foreach ($responses as $response) {
            $user = DB::table('users')->find($response->user_id);
            echo "- Response ID {$response->id} by {$user->name} ({$user->email})\n";

            // Cek answers untuk response ini
            $answers = DB::table('survey_answers')
                ->where('response_id', $response->id)
                ->get();

            echo "  Answers count: " . $answers->count() . "\n";

            foreach ($answers as $answer) {
                echo "  - Q{$answer->question_id}: '{$answer->answer}' (value: {$answer->value}, score: {$answer->score})\n";
            }
        }

        echo "\n";
    }

    // 3. Cek total survey_answers
    echo "3. Total Survey Answers:\n";
    $totalAnswers = DB::table('survey_answers')->count();
    echo "Total: {$totalAnswers} answers\n\n";

    // 4. Cek survey_answers per section
    echo "4. Survey Answers per Section:\n";
    foreach ($sections as $section) {
        $responses = DB::table('survey_responses')->where('survey_id', $section)->pluck('id');
        $answerCount = DB::table('survey_answers')->whereIn('response_id', $responses)->count();
        echo "Section {$section}: {$answerCount} answers\n";
    }

    echo "\n";

    // 5. Cek sample data untuk section C
    echo "5. Sample data untuk Section C:\n";
    $sectionCResponses = DB::table('survey_responses')->where('survey_id', 'C')->get();

    foreach ($sectionCResponses as $response) {
        $user = DB::table('users')->find($response->user_id);
        echo "Response ID {$response->id} by {$user->name}:\n";

        $answers = DB::table('survey_answers')
            ->where('response_id', $response->id)
            ->orderBy('question_id')
            ->get();

        foreach ($answers as $answer) {
            echo "  C{$answer->question_id}: '{$answer->answer}'\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
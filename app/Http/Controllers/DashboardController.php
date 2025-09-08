<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\SurveyResponse;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

        $sections = $this->sections;
        $userResponses = SurveyResponse::where('user_id', Auth::id())->get()->keyBy('survey_id');


        $progress = [];
        foreach ($sections as $key => $value) {
            $response[$key] = SurveyResponse::firstOrCreate(
                ['user_id' => $user->id, 'survey_id' => $key],
                ['completed' => false]
            );

            // Find section in survey data
            $sectionData = collect($surveyData['sections'])->where('id', $key)->first();

            // Handle different section structures
            $totalQuestions = 0;
            if (isset($sectionData['questions'])) {
                $totalQuestions = count($sectionData['questions']);
            } elseif (isset($sectionData['subsections'])) {
                // For sections like C that use subsections
                foreach ($sectionData['subsections'] as $subsection) {
                    if (isset($subsection['questions'])) {
                        $totalQuestions += count($subsection['questions']);
                    }
                }
            }

            // Get answered questions
            $answeredQuestions[$key] = $response[$key]->answers()->pluck('question_id')->toArray();
            $answeredCount = count($answeredQuestions[$key]);

            // Calculate progress
            $progress[$key] = $totalQuestions > 0 ? round(($answeredCount / $totalQuestions) * 100) : 0;
            $progress[$key] = max(0, min(100, $progress[$key]));
        }

        // Calculate overall status
        $totalSections = count($sections);
        $completedSections = $userResponses->where('completed', true)->count();
        $overallStatus = 'TIDAK LENGKAP';
        if ($completedSections === $totalSections) {
            $overallStatus = 'LENGKAP';
        } elseif ($completedSections > 0) {
            $overallStatus = 'SEBAHAGIAN LENGKAP';
        }

        return view('dashboard-enhanced', [
            'sections' => $sections,
            'responses' => $userResponses,
            'progress' => $progress,
            'overallStatus' => $overallStatus
        ]);
    }

    private function calculateProgress($answered, $allQuestions)
    {
        $total = count($allQuestions);
        $answeredCount = count($answered);
        return $total > 0 ? round(($answeredCount / $total) * 100) : 0;
    }
}

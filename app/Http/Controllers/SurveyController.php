<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function show($section)
    {
        $user = Auth::user();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

        // Get or create survey response
        $response = SurveyResponse::firstOrCreate(
            ['user_id' => $user->id, 'survey_id' => $section],
            ['completed' => false]
        );

        // Get answered questions
        $answeredQuestions = $response->answers()->pluck('question_id')->toArray();

        // Find next unanswered question
        $questions = collect($surveyData['sections'])
            ->where('id', $section)
            ->first()['questions'] ?? [];

        $currentQuestion = null;
        foreach ($questions as $question) {
            if (!in_array($question['id'], $answeredQuestions)) {
                $currentQuestion = $question;
                break;
            }
        }

        if (!$currentQuestion) {
            // All questions answered, calculate score
            $this->calculateScore($response, $section, $surveyData);
            $response->update(['completed' => true]);
            return redirect()->route('survey.results', $section);
        }
        return view('survey.question', [
            'section' => $section,
            'question' => $currentQuestion,
            'progress' => $this->calculateProgress($answeredQuestions, $questions),
            'sectionTitle' => $surveyData['sections'][array_search($section, array_column($surveyData['sections'], 'id'))]['title_BM']
        ]);
    }

    public function store(Request $request, $section)
    {
        $request->validate([
            'question_id' => 'required',
            'answer' => 'required'
        ]);

        $response = SurveyResponse::where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        SurveyAnswer::create([
            'response_id' => $response->id,
            'question_id' => $request->question_id,
            'answer' => $request->answer
        ]);

        return redirect()->route('survey.show', $section);
    }

    public function results($section)
    {
        $response = SurveyResponse::with('scores')
            ->where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        return view('survey.results', [
            'section' => $section,
            'response' => $response,
            'sectionData' => $sectionData
        ]);
    }

    public function review($section)
    {
        $response = SurveyResponse::with('answers')
            ->where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $questions = collect($surveyData['sections'])->where('id', $section)->first()['questions'] ?? [];

        return view('survey.review', [
            'section' => $section,
            'response' => $response,
            'questions' => $questions,
            'sectionTitle' => $surveyData['sections'][array_search($section, array_column($surveyData['sections'], 'id'))]['title_BM']
        ]);
    }

    public function edit($section, $questionId)
    {
        $user = Auth::user();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

        $response = SurveyResponse::where('user_id', $user->id)
            ->where('survey_id', $section)
            ->firstOrFail();

        $questions = collect($surveyData['sections'])
            ->where('id', $section)
            ->first()['questions'] ?? [];

        $question = collect($questions)->where('id', $questionId)->first();
        if (!$question) {
            abort(404, 'Soalan tidak dijumpai');
        }

        $answer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $questionId)
            ->first();

        return view('survey.edit', [
            'section' => $section,
            'question' => $question,
            'answer' => $answer,
            'sectionTitle' => $surveyData['sections'][array_search($section, array_column($surveyData['sections'], 'id'))]['title_BM']
        ]);
    }

    public function update(Request $request, $section, $questionId)
    {
        $request->validate([
            'answer' => 'required'
        ]);

        $response = SurveyResponse::where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $answer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $questionId)
            ->first();

        if ($answer) {
            $answer->update(['answer' => $request->answer]);
        } else {
            SurveyAnswer::create([
                'response_id' => $response->id,
                'question_id' => $questionId,
                'answer' => $request->answer
            ]);
        }

        return redirect()->route('survey.review', $section)->with('success', 'Jawapan berjaya dikemaskini');
    }

    private function calculateProgress($answered, $allQuestions)
    {
        $total = count($allQuestions);
        $answeredCount = count($answered);
        return $total > 0 ? round(($answeredCount / $total) * 100) : 0;
    }

    private function calculateScore($response, $section, $surveyData)
    {
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();
        $answers = $response->answers()->get();

        // Implement scoring logic based on section
        $score = 0;
        $category = '';
        $recommendation = '';

        // Example for Section B (Work Ability Index)
        if ($section === 'B') {
            foreach ($answers as $answer) {
                // Extract numeric value from answer
                if (preg_match('/\((\d+)\)/', $answer->answer, $matches)) {
                    $score += (int)$matches[1];
                } elseif (is_numeric($answer->answer)) {
                    $score += (int)$answer->answer;
                }
            }

            // Determine category based on score ranges
            foreach ($sectionData['scoring']['ranges'] as $range) {
                list($min, $max) = explode('-', $range['score']);
                if ($score >= $min && $score <= $max) {
                    $category = $range['category'];
                    $recommendation = $sectionData['scoring']['recommendations'][$category];
                    break;
                }
            }
        }

        // Save the score
        SurveyScore::create([
            'response_id' => $response->id,
            'section' => $section,
            'score' => $score,
            'category' => $category,
            'recommendation' => $recommendation
        ]);
    }
}

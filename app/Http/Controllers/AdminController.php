<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Respondent;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all responders
     */
    public function responders()
    {
        $responders = User::with(['respondent', 'surveyResponses'])
            ->whereHas('surveyResponses')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->respondent->phone_number ?? '-',
                    'age' => $user->respondent->age ?? '-',
                    'gender' => $user->respondent->gender ?? '-',
                    'location' => $user->respondent->location ?? '-',
                    'completed_surveys' => $user->surveyResponses->where('completed', true)->count(),
                    'total_surveys' => $user->surveyResponses->count(),
                    'created_at' => $user->created_at->toDateTimeString(),
                ];
            });

        return view('admin.responders.index-new', compact('responders'));
    }

    /**
     * Display detailed answers for a specific responder
     */
    public function showResponder($id)
    {
        $user = User::with(['respondent', 'surveyResponses.answers', 'surveyResponses.scores'])->findOrFail($id);

        $responses = $user->surveyResponses->map(function ($response) {
            return [
                'id' => $response->id,
                'survey_id' => $response->survey_id,
                'completed' => $response->completed,
                'created_at' => $response->created_at->toDateTimeString(),
                'answers' => $response->answers->map(function ($answer) {
                    return [
                        'question_id' => $answer->question_id,
                        'answer' => $answer->answer,
                    ];
                }),
                'scores' => $response->scores->map(function ($score) {
                    return [
                        'category' => $score->category,
                        'score' => $score->score,
                    ];
                }),
            ];
        });

        return view('admin.responders.show-new', compact('user', 'responses'));
    }
}

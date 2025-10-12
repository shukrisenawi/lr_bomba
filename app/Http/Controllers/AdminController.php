<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Respondent;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RespondersExport;

class AdminController extends Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Display a listing of all responders
     */
    public function responders()
    {
        $responders = User::with(['respondent', 'surveyResponses'])
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
     * Export all responders data to Excel
     */
    public function export()
    {
        return Excel::download(new RespondersExport, 'data_responder_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Display detailed answers for a specific responder
     */
    public function showResponder($id)
    {
        $user = User::with([
            'respondent',
            'surveyResponses.answers',
            'surveyResponses.scores'
        ])->findOrFail($id);

        $questionMappingService = new \App\Services\SurveyQuestionMappingService();

        $responses = $user->surveyResponses->map(function ($response) use ($questionMappingService) {
            return [
                'id' => $response->id,
                'survey_id' => $response->survey_id,
                'completed' => $response->completed,
                'created_at' => $response->created_at->toDateTimeString(),
                'answers' => $response->answers->map(function ($answer) use ($questionMappingService) {
                    $context = $questionMappingService->getQuestionContext($answer->question_id);
                    return [
                        'question_id' => $answer->question_id,
                        'question_context' => $context,
                        'answer' => $answer->answer ?? '',
                        'score' => $answer->score,
                        'value' => $answer->value,
                    ];
                }),
                'scores' => $response->scores->groupBy('section')->map(function ($sectionScores, $section) {
                    $sectionTitle = $section;
                    // Try to get section title from config if available
                    // if (function_exists('getFullSectionTitle')) {
                    //     $sectionTitle = getFullSectionTitle($section) ?? $section;
                    // }
                    $sectionTitle = isset($this->scoreLabels[$sectionTitle]) ? $this->scoreLabels[$sectionTitle] : $sectionTitle;

                    return [
                        'section' => $section,
                        'section_title' => $sectionTitle,
                        'scores' => $sectionScores->map(function ($score) {
                            return [
                                'category' => $score->category ?? 'Unknown',
                                'score' => $score->score ?? 0,
                                'recommendation' => $score->recommendation ?? '',
                            ];
                        }),
                    ];
                }),
            ];
        });

        return view('admin.responders.show-enhanced', compact('user', 'responses'));
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        // Store original admin ID in session if not already impersonating
        if (!session()->has('admin_id')) {
            session(['admin_id' => Auth::id()]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function userRole($id)
    {
        $user = User::findOrFail($id);
        // This is a placeholder. A dedicated view should be created for this.
        return "<h1>User Role: {$user->name}</h1><p>Role: {$user->role}</p>";
    }

    public function revertImpersonate(Request $request)
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = $request->session()->pull('admin_id');
        $admin = User::findOrFail($adminId);

        Auth::login($admin);

        return redirect()->route('admin.responders');
    }
}

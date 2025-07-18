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

        $sections = ['A' => 'BAHAGIAN A: Latarbelakang Demografi Responden', 'B' => 'BAHAGIAN B: Indek Kebolehan Bekerja ', 'C' => 'BAHAGIAN C: Soal-selidik Kandungan Kerja', 'D' => 'BAHAGIAN D: Impak Latihan Di Tempat Kerja', 'E' => 'BAHAGIAN E: Soal-selidik Prestasi Keja Individu', 'F' => 'BAHAGIAN F: Skala Kemurungan Psikologikal Kessler 6 ', 'G' => 'BAHAGIAN G: Skala Kemurungan CES-D', 'H' => 'BAHAGIAN H: Instrumen Penilaian Kepenatan', 'I' => 'BAHAGIAN I: Penilaian Anggota Keseluruhan Tubuh (REBA)'];
        $userResponses = SurveyResponse::where('user_id', Auth::id())->get()->keyBy('survey_id');


        $progress = [];
        foreach ($sections as $key => $value) {
            $response[$key] = SurveyResponse::firstOrCreate(
                ['user_id' => $user->id, 'survey_id' => $key],
                ['completed' => false]
            );
            $questions[$key] = collect($surveyData['sections'])
                ->where('id', $key)
                ->first()['questions'] ?? [];

            // Get answered questions
            $answeredQuestions[$key] = $response[$key]->answers()->pluck('question_id')->toArray();
            $progress[$key] = $this->calculateProgress($answeredQuestions[$key], $questions[$key]);
        }

        return view('dashboard', [
            'sections' => $sections,
            'responses' => $userResponses,
            'progress' => $progress
        ]);
    }

    private function calculateProgress($answered, $allQuestions)
    {
        $total = count($allQuestions);
        $answeredCount = count($answered);
        return $total > 0 ? round(($answeredCount / $total) * 100) : 0;
    }
}

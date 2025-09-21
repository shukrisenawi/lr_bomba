<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;

class SectionCStatusCalculationService
{
    private $medianService;

    public function __construct(MedianScoreCalculationService $medianService)
    {
        $this->medianService = $medianService;
    }

    /**
     * Calculate status and recommendations for Section C based on psychological demands and decision control
     */
    public function calculateStatusAndRecommendations(SurveyResponse $response): array
    {
        // Get median scores
        $medianScores = $this->medianService->getMedianScores();

        // Calculate individual scores for current respondent
        $psychologicalDemandScore = $this->calculateSubsectionScore($response, ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8']);
        $decisionControlScore = $this->calculateSubsectionScore($response, ['C9', 'C10', 'C11', 'C12', 'C13', 'C14', 'C15']);

        // Determine if scores are high/low compared to median
        $psychologicalDemandMedian = $medianScores['Tuntutan Psikologi'] ?? 0;
        $decisionControlMedian = $medianScores['Kawalan Keputusan'] ?? 0;

        $isPsychologicalDemandHigh = $psychologicalDemandScore >= $psychologicalDemandMedian;
        $isDecisionControlHigh = $decisionControlScore >= $decisionControlMedian;

        // Determine status based on combination
        $status = $this->determineStatus($isPsychologicalDemandHigh, $isDecisionControlHigh);

        // Get recommendation based on status
        $recommendation = $this->getRecommendation($status);

        return [
            'psychological_demand_score' => $psychologicalDemandScore,
            'decision_control_score' => $decisionControlScore,
            'psychological_demand_median' => $psychologicalDemandMedian,
            'decision_control_median' => $decisionControlMedian,
            'status' => $status,
            'recommendation' => $recommendation
        ];
    }

    /**
     * Calculate total score for a subsection
     */
    private function calculateSubsectionScore(SurveyResponse $response, array $questionIds): float
    {
        $totalScore = 0;
        $answeredQuestions = 0;

        foreach ($questionIds as $questionId) {
            $answer = $response->answers()->where('question_id', $questionId)->first();
            if ($answer && $answer->score !== null) {
                $totalScore += $answer->score;
                $answeredQuestions++;
            }
        }

        return $answeredQuestions > 0 ? $totalScore : 0;
    }

    /**
     * Determine status based on psychological demand and decision control combination
     */
    private function determineStatus(bool $isPsychologicalDemandHigh, bool $isDecisionControlHigh): string
    {
        if ($isPsychologicalDemandHigh && !$isDecisionControlHigh) {
            return 'Pekerjaan Bertekanan Tinggi';
        } elseif ($isPsychologicalDemandHigh && $isDecisionControlHigh) {
            return 'Pekerjaan Aktif';
        } elseif (!$isPsychologicalDemandHigh && !$isDecisionControlHigh) {
            return 'Pekerjaan Pasif';
        } elseif (!$isPsychologicalDemandHigh && $isDecisionControlHigh) {
            return 'Pekerjaan Bertekanan Rendah';
        }

        return 'Tidak Dapat Ditentukan';
    }

    /**
     * Get recommendation based on status from JSON
     */
    private function getRecommendation(string $status): string
    {
        // Load survey data from JSON
        $surveyPath = storage_path('app/survey/1st_draft.json');
        if (!file_exists($surveyPath)) {
            return 'Fail soal selidik tidak dijumpai.';
        }

        $surveyData = json_decode(file_get_contents($surveyPath), true);
        if (!$surveyData || !isset($surveyData['sections'])) {
            return 'Struktur soal selidik tidak sah.';
        }

        // Find Section C
        $sectionC = collect($surveyData['sections'])->where('id', 'C')->first();
        if (!$sectionC || !isset($sectionC['recommendations'])) {
            return 'Bahagian C atau recommendations tidak dijumpai.';
        }

        // Get recommendation based on status
        return $sectionC['recommendations'][$status] ?? 'Saranan tidak tersedia untuk status ini.';
    }
}
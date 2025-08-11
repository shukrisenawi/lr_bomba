<?php

namespace App\Services;

use App\Models\SurveyResponse;
use App\Models\SurveyScore;

class RebaScoreCalculationService
{
    // private $scoreService;

    // public function __construct(ScoreCalculationService $scoreService)
    // {
    //     $this->scoreService = $scoreService;
    // }

    public function calculateRebaScore(SurveyResponse $response)
    {
        $answers = $response->answers()->get()->keyBy('question_id');

        // TABLE A: Neck, Trunk, Legs
        $neck = $answers->get('1')->score ?? 0;
        $neck_adj = $answers->get('1a')->score ?? 0;
        $neck_score = $neck + $neck_adj;

        $trunk = $answers->get('2')->score ?? 0;
        $trunk_adj = $answers->get('2a')->score ?? 0;
        $trunk_score = $trunk + $trunk_adj;

        $legs = $answers->get('3')->score ?? 0;
        $legs_adj = $answers->get('3a')->score ?? 0;
        $leg_score = $legs + $legs_adj;


        $tableA_score = $this->getTableA_Score($neck_score, $trunk_score, $leg_score);
        $load_force = $answers->get('4')->score ?? 0;
        $scoreA = $tableA_score + $load_force;

        // TABLE B: Arms and Wrists
        $upper_arm = $answers->get('5')->score ?? 0;
        $upper_arm_adj = $answers->get('5a')->score ?? 0;
        $upper_arm_score = $upper_arm + $upper_arm_adj;

        $lower_arm_score = $answers->get('A6')->score ?? 0;

        $wrist = $answers->get('7')->score ?? 0;
        $wrist_adj = $answers->get('7a')->score ?? 0;
        $wrist_score = $wrist + $wrist_adj;

        $tableB_score = $this->getTableB_Score($upper_arm_score, $lower_arm_score, $wrist_score);

        $coupling = $answers->get('8')->score ?? 0;
        $scoreB = $tableB_score + $coupling;

        // TABLE C
        $tableC_score = $this->getTableC_Score($scoreA, $scoreB);

        $activity = $answers->get('9')->score ?? 0;
        $final_reba_score = $tableC_score + $activity;

        return [
            'Bahagian A' => $scoreA,
            'Bahagian B' => $scoreB,
            'REBA' => $tableC_score
        ];
    }

    private function getTableA_Score($neck, $trunk, $legs)
    {
        $table = [
            // Neck Score 1
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                2 => [1 => 2, 2 => 3, 3 => 4, 4 => 5],
                3 => [1 => 2, 2 => 4, 3 => 5, 4 => 6],
                4 => [1 => 3, 2 => 5, 3 => 6, 4 => 7],
                5 => [1 => 4, 2 => 6, 3 => 7, 4 => 8],
            ],
            // Neck Score 2
            2 => [
                1 => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                2 => [1 => 3, 2 => 4, 3 => 5, 4 => 6],
                3 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                4 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
                5 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
            ],
            // Neck Score 3
            3 => [
                1 => [1 => 3, 2 => 3, 3 => 5, 4 => 6],
                2 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                3 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
                4 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
                5 => [1 => 7, 2 => 8, 3 => 9, 4 => 9],
            ],
        ];
        return $table[$neck][$trunk][$legs] ?? 0;
    }

    private function getTableB_Score($upper_arm, $lower_arm, $wrist)
    {
        $table = [
            // Upper Arm 1
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 2],
                2 => [1 => 1, 2 => 2, 3 => 3],
                3 => [1 => 3, 2 => 4, 3 => 5],
                4 => [1 => 4, 2 => 5, 3 => 5],
                5 => [1 => 6, 2 => 7, 3 => 8],
                6 => [1 => 7, 2 => 8, 3 => 8],
            ],
            // Upper Arm 2
            2 => [
                1 => [1 => 1, 2 => 2, 3 => 3],
                2 => [1 => 2, 2 => 3, 3 => 4],
                3 => [1 => 4, 2 => 5, 3 => 5],
                4 => [1 => 5, 2 => 6, 3 => 7],
                5 => [1 => 7, 2 => 8, 3 => 8],
                6 => [1 => 8, 2 => 9, 3 => 9],
            ]
        ];
        return $table[$upper_arm][$lower_arm][$wrist] ?? 0;
    }

    private function getTableC_Score($scoreA, $scoreB)
    {
        $table = [
            // Score A = 1
            1 => [1 => 1, 2 => 1, 3 => 2, 4 => 3, 5 => 4, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12],
            // Score A = 2
            2 => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 4, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12],
            // Score A = 3
            3 => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 4, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12],
            // Score A = 4
            4 => [1 => 2, 2 => 3, 3 => 3, 4 => 4, 5 => 5, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 11, 12 => 12],
            // Score A = 5
            5 => [1 => 3, 2 => 4, 3 => 4, 4 => 5, 5 => 6, 6 => 8, 7 => 9, 8 => 10, 9 => 10, 10 => 11, 11 => 12, 12 => 12],
            // Score A = 6
            6 => [1 => 3, 2 => 4, 3 => 5, 4 => 6, 5 => 7, 6 => 8, 7 => 9, 8 => 10, 9 => 10, 10 => 11, 11 => 12, 12 => 12],
            // Score A = 7
            7 => [1 => 4, 2 => 5, 3 => 6, 4 => 7, 5 => 8, 6 => 9, 7 => 9, 8 => 10, 9 => 11, 10 => 11, 11 => 12, 12 => 12],
            // Score A = 8
            8 => [1 => 5, 2 => 6, 3 => 7, 4 => 8, 5 => 8, 6 => 9, 7 => 10, 8 => 10, 9 => 11, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 9
            9 => [1 => 6, 2 => 6, 3 => 7, 4 => 8, 5 => 9, 6 => 10, 7 => 10, 8 => 10, 9 => 11, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 10
            10 => [1 => 7, 2 => 7, 3 => 8, 4 => 9, 5 => 9, 6 => 10, 7 => 11, 8 => 11, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 11
            11 => [1 => 7, 2 => 7, 3 => 8, 4 => 9, 5 => 9, 6 => 10, 7 => 11, 8 => 11, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 12
            12 => [1 => 7, 2 => 8, 3 => 8, 4 => 9, 5 => 9, 6 => 10, 7 => 11, 8 => 11, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
        ];
        // Ensure scoreB is within the valid range [1, 12]
        $scoreB = max(1, min(12, $scoreB));
        return $table[$scoreA][$scoreB] ?? 0;
    }
}

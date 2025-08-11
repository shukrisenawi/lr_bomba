<?php

namespace App\Services;


class RebaScoreCalculationService
{
    /**
     * Calculate REBA scores for Bahagian I
     */
    public function calculateRebaScores(array $responses): array
    {
        $skorBahagianA = $this->calculatePartAScore($responses);
        $skorBahagianB = $this->calculatePartBScore($responses);

        $scores = [
            'Skor Bahagian A' => $skorBahagianA,
            'Skor Bahagian B' => $skorBahagianB,
            'Skor keseluruhan' => $skorBahagianA + $skorBahagianB,
        ];

        return $scores;
    }


    /**
     * Calculate Part A score (Neck, Trunk, Legs)
     */
    private function calculatePartAScore(array $responses): int
    {
        $neckScore = $this->getNeckScore($responses['neck_position'] ?? 0, $responses['neck_adjustment'] ?? 0);
        $trunkScore = $this->getTrunkScore($responses['trunk_position'] ?? 0, $responses['trunk_adjustment'] ?? 0);
        $legScore = $this->getLegScore($responses['leg_position'] ?? 0, $responses['leg_adjustment'] ?? 0);
        $loadScore = $this->getLoadScore($responses['load_weight'] ?? 0, $responses['load_frequency'] ?? 0);

        return $neckScore + $trunkScore + $legScore + $loadScore;
    }

    /**
     * Calculate Part B score (Arm and Wrist)
     */
    private function calculatePartBScore(array $responses): int
    {
        $upperArmScore = $this->getUpperArmScore($responses['upper_arm_position'] ?? 0, $responses['upper_arm_adjustment'] ?? 0);
        $lowerArmScore = $this->getLowerArmScore($responses['lower_arm_position'] ?? 0);
        $wristScore = $this->getWristScore($responses['wrist_position'] ?? 0, $responses['wrist_adjustment'] ?? 0);
        $gripScore = $this->getGripScore($responses['grip_type'] ?? 0);
        $activityScore = $this->getActivityScore($responses['activity_type'] ?? 0);

        return $upperArmScore + $lowerArmScore + $wristScore + $gripScore + $activityScore;
    }

    /**
     * Get neck score based on position and adjustment
     */
    private function getNeckScore(int $position, int $adjustment): int
    {
        $baseScores = [
            1 => 1, // Neutral
            2 => 2, // Flexion/extension
            3 => 3  // Rotation
        ];

        return $baseScores[$position] + $adjustment;
    }

    /**
     * Get trunk score based on position and adjustment
     */
    private function getTrunkScore(int $position, int $adjustment): int
    {
        $baseScores = [
            1 => 1, // Neutral
            2 => 2, // Flexion/extension
            3 => 3, // Rotation
            4 => 4  // Lateral flexion
        ];

        return $baseScores[$position] + $adjustment;
    }

    /**
     * Get leg score based on position and adjustment
     */
    private function getLegScore(int $position, int $adjustment): int
    {
        $baseScores = [
            1 => 1, // Both feet supported
            2 => 2  // One foot supported
        ];

        return $baseScores[$position] + $adjustment;
    }

    /**
     * Get load score based on weight and frequency
     */
    private function getLoadScore(float $weight, int $frequency): int
    {
        if ($weight <= 5) return 0;
        if ($weight <= 10) return 1;
        if ($weight <= 20) return 2;
        return 3;
    }

    /**
     * Get upper arm score
     */
    private function getUpperArmScore(int $position, int $adjustment): int
    {
        $baseScores = [
            1 => 1, // Neutral
            2 => 2, // Flexion/extension
            3 => 3, // Abduction
            4 => 4  // Rotation
        ];

        return $baseScores[$position] + $adjustment;
    }

    /**
     * Get lower arm score
     */
    private function getLowerArmScore(int $position): int
    {
        return $position;
    }

    /**
     * Get wrist score
     */
    private function getWristScore(int $position, int $adjustment): int
    {
        $baseScores = [
            1 => 1, // Neutral
            2 => 2  // Flexion/extension
        ];

        return $baseScores[$position] + $adjustment;
    }

    /**
     * Get grip score
     */
    private function getGripScore(int $type): int
    {
        return $type;
    }

    /**
     * Get activity score
     */
    private function getActivityScore(int $type): int
    {
        return $type;
    }

    /**
     * Get REBA risk level based on overall score
     */
    public function getRiskLevel(int $overallScore): string
    {
        if ($overallScore <= 1) return 'Tiada risiko';
        if ($overallScore <= 3) return 'Risiko rendah';
        if ($overallScore <= 7) return 'Risiko sederhana';
        if ($overallScore <= 10) return 'Risiko tinggi';
        return 'Risiko sangat tinggi';
    }
}

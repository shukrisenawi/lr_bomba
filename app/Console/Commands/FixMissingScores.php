<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Services\ScoreCalculationService;

class FixMissingScores extends Command
{
    protected $signature = 'scores:fix-missing';
    protected $description = 'Fix missing scores for survey responses';

    public function handle()
    {
        $this->info('Starting to fix missing scores...');
        
        $responses = SurveyResponse::with(['answers', 'scores'])->get();
        $scoreService = new ScoreCalculationService();
        
        $fixedCount = 0;
        
        foreach ($responses as $response) {
            $this->info("Processing response ID: {$response->id}");
            
            // Fix individual answer scores
            foreach ($response->answers as $answer) {
                if ($answer->score === null && $answer->value !== null) {
                    $score = $this->calculateScoreFromValue($answer->value);
                    $answer->update(['score' => $score]);
                    $this->line("Fixed score for answer ID: {$answer->id}");
                }
            }
            
            // Fix section scores
            $sections = $response->answers->pluck('section')->unique();
            
            foreach ($sections as $section) {
                $sectionAnswers = $response->answers->where('section', $section);
                $sectionScore = $sectionAnswers->sum('score');
                
                // Update or create section score
                $response->scores()->updateOrCreate(
                    ['section' => $section],
                    ['score' => $sectionScore]
                );
            }
            
            $fixedCount++;
        }
        
        $this->info("Completed! Fixed scores for {$fixedCount} responses.");
    }
    
    private function calculateScoreFromValue($value)
    {
        // Convert value to score based on your scoring logic
        // This is a simple example - adjust based on your actual scoring rules
        if (is_numeric($value)) {
            return (int) $value;
        }
        
        // Handle other value types as needed
        return 0;
    }
}

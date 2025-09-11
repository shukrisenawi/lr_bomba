<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MedianScoreCalculationService;

class CalculateMedianScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-median-scores {--force : Force recalculation even if data exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate median scores for Section C subsections from all respondents';

    protected $medianScoreService;

    public function __construct(MedianScoreCalculationService $medianScoreService)
    {
        parent::__construct();
        $this->medianScoreService = $medianScoreService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perhitungan median skor untuk bahagian C...');

        try {
            // Calculate median scores
            $medianScores = $this->medianScoreService->calculateMedianScoresForSectionC();

            // Display results
            $this->info('Hasil perhitungan median skor:');
            $this->table(
                ['Subbagian', 'Median Skor', 'Jumlah Responden', 'Jumlah Soalan'],
                array_map(function($subsection, $data) {
                    return [
                        $subsection,
                        number_format($data['median'], 2),
                        $data['total_respondents'],
                        $data['question_count']
                    ];
                }, array_keys($medianScores), $medianScores)
            );

            // Save to database
            $this->medianScoreService->saveMedianScores($medianScores);
            $this->info('Median skor telah disimpan ke database.');

            // Show current saved median scores
            $savedScores = $this->medianScoreService->getMedianScores();
            $this->info('Median skor yang tersimpan:');
            foreach ($savedScores as $subsection => $score) {
                $this->line("{$subsection}: " . number_format($score, 2));
            }

        } catch (\Exception $e) {
            $this->error('Ralat semasa mengira median skor: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        $this->info('Perhitungan median skor selesai.');
        return 0;
    }
}

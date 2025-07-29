<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use App\Services\ScoreCalculationService;
use App\Services\SubsectionScoreCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    protected $scoreService;
    protected $subsectionScoreService;

    public function __construct(ScoreCalculationService $scoreService, \App\Services\SubsectionScoreCalculationService $subsectionScoreService)
    {
        $this->scoreService = $scoreService;
        $this->subsectionScoreService = $subsectionScoreService;
    }

    public function show($section)
    {
        $user = Auth::user();

        // Validate survey file exists
        $surveyPath = storage_path('app/survey/1st_draft.json');
        if (!file_exists($surveyPath)) {
            return redirect()->route('dashboard')->with('error', 'Fail soal selidik tidak dijumpai.');
        }

        try {
            $surveyData = json_decode(file_get_contents($surveyPath), true);


            if (!$surveyData || !isset($surveyData['sections'])) {

                return redirect()->route('dashboard')->with('error', 'Struktur soal selidik tidak sah.');
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Ralat membaca fail soal selidik.');
        }

        // Get or create survey response
        $response = SurveyResponse::firstOrCreate(
            ['user_id' => $user->id, 'survey_id' => $section],
            ['completed' => false]
        );

        // Get answered questions
        $answeredQuestions = $response->answers()->pluck('question_id')->toArray();

        // Find section data
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();


        if (!$sectionData) {
            return redirect()->route('dashboard')->with('error', 'Bahagian soal selidik tidak dijumpai.');
        }

        // Extract all questions including those in subsections
        $questions = $this->extractAllQuestions($sectionData);

        // Add subsection info to questions from subsections
        $questionsWithSubsection = [];
        if (isset($sectionData['questions']) && !empty($sectionData['questions'])) {
            $questionsWithSubsection = $sectionData['questions'];
        }

        if (isset($sectionData['subsections']) && !empty($sectionData['subsections'])) {
            foreach ($sectionData['subsections'] as $subsection) {
                if (isset($subsection['questions']) && !empty($subsection['questions'])) {
                    foreach ($subsection['questions'] as $question) {
                        // Add subsection info to each question
                        $question['subsection_name'] = $subsection['name'];
                        $questionsWithSubsection[] = $question;
                    }
                }
            }
        }
        $questions = $questionsWithSubsection;

        // Normalize question structure to handle "option" vs "options" key inconsistency
        $questions = array_map(function ($question) use ($surveyData, $response) {
            // Handle the case where "option" is used instead of "options"
            if (isset($question['option']) && !isset($question['options'])) {
                $question['options'] = $question['option'];
                unset($question['option']);
            }

            // Handle optionsReferer for dynamic options
            if (isset($question['optionsReferer'])) {
                $answers = $response->answers()->pluck('answer', 'question_id')->toArray();

                $question['options'] = get_referer_options($question, $surveyData, $answers);
            }

            // Ensure options is always an array, even if empty
            if (!isset($question['options'])) {
                $question['options'] = [];
            }
            return $question;
        }, $questions);
        if (empty($questions)) {
            return redirect()->route('dashboard')->with('error', 'Tiada soalan dalam bahagian ini.');
        }

        // Find next unanswered question
        $currentQuestion = null;
        $unansweredQuestions = [];

        foreach ($questions as $question) {
            if (!in_array($question['id'], $answeredQuestions)) {
                $unansweredQuestions[] = $question;
                if (!$currentQuestion) {
                    $currentQuestion = $question;
                }
            }
        }
        if (!$currentQuestion) {
            // All questions answered, calculate score
            $this->calculateScore($response, $section, $surveyData);
            $response->update(['completed' => true]);
            return redirect()->route('survey.results', $section);
        }

        // Find section title safely
        $sectionIndex = array_search($section, array_column($surveyData['sections'], 'id'));
        $sectionTitle = $sectionIndex !== false ? $surveyData['sections'][$sectionIndex]['title_BM'] : 'Bahagian ' . $section;

        $answer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $currentQuestion['id'])
            ->first();

        return view('survey.question-beautiful', [
            'section' => $section,
            'question' => $currentQuestion,
            'answer' => $answer,
            'progress' => $this->calculateProgress($answeredQuestions, $questions),
            'sectionTitle' => $sectionTitle,
            'debug_info' => config('app.debug') ? [
                'total_questions' => count($questions),
                'answered' => count($answeredQuestions),
                'remaining' => count($unansweredQuestions)
            ] : null
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

        // Get survey data to determine question type
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        if (!$sectionData) {
            return redirect()->route('survey.show', $section)->with('error', 'Bahagian soal selidik tidak dijumpai.');
        }
        // Extract all questions including those in subsections
        $questions = collect($this->extractAllQuestions($sectionData));
        $question = $questions->where('id', $request->question_id)->first();

        $answerInput = $request->answer;

        // Handle multiText questions - ensure arrays are properly serialized
        if ($question && $question['type'] === 'multiText') {
            if (is_array($answerInput)) {
                // Already an array, encode to JSON string
                $answerInput = json_encode($answerInput);
            }
            // If it's a string, we assume it's a valid JSON string from the component and pass it through.
        } else {
            // Handle other question types
            if (is_array($answerInput)) {
                // For non-multiText, take first element or serialize
                $answerInput = json_encode($answerInput);
            } elseif (is_string($answerInput)) {
                // Check if it's JSON for radio buttons
                $decoded = json_decode($answerInput, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $answerInput = $decoded[0] ?? $answerInput;
                }
            }
        }

        $answerData = $this->processAnswerData($question, $answerInput, $response->id, $request->question_id);

        SurveyAnswer::create($answerData);

        return redirect()->route('survey.show', $section);
    }

    /**
     * Process answer data based on question type
     */
    private function processAnswerData($question, $selectedAnswer, $responseId, $questionId)
    {
        $baseData = [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => $selectedAnswer,
            'value' => null,
            'score' => null
        ];

        // Handle different question types
        if ($question) {
            if ($question['type'] === 'single_choice')
                return $this->processRadioButtonAnswer($question, $selectedAnswer, $responseId, $questionId);
            else if ($question['type'] === 'multiple_choice') {
                return $this->processMultipleChoiceAnswer($question, $selectedAnswer, $responseId, $questionId);
            } else if ($question['type'] === 'scale')
                return $this->processScaleAnswer($question, $selectedAnswer, $responseId, $questionId);
            else if ($question['type'] === 'numeric')
                return $this->processNumericAnswer($question, $selectedAnswer, $responseId, $questionId);
            else if ($question['type'] === 'multiText') {
                // Ensure multiText answers are properly formatted as JSON strings
                if (is_array($selectedAnswer) || is_object($selectedAnswer)) {
                    $jsonAnswer = json_encode($selectedAnswer);

                    $baseData['answer'] = $jsonAnswer;
                    $baseData['value'] = $jsonAnswer;
                } else {
                    // Already a JSON string or single value
                    $baseData['answer'] = $selectedAnswer;
                    $baseData['value'] = $selectedAnswer;
                }
                return $baseData;
            }
        }
        // dd("stop");
        // For other question types, just store the answer as-is
        return $baseData;
    }
    private function processScaleAnswer($question, $selectedValue, $responseId, $questionId)
    {
        return [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => $selectedValue,
            'value' => $selectedValue,
            'score' => $selectedValue
        ];
    }

    /**
     * Process numeric answer for physical fitness tests
     */
    private function processNumericAnswer($question, $selectedValue, $responseId, $questionId)
    {
        // Convert to numeric value
        $numericValue = is_numeric($selectedValue) ? (float)$selectedValue : 0;

        return [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => $selectedValue . ' ' . ($question['unit'] ?? ''),
            'value' => $numericValue,
            'score' => $numericValue // For IPPT, the raw value is the score
        ];
    }
    /**
     * Process radio button answer to extract text, value, and score
     */
    private function processRadioButtonAnswer($question, $selectedValue, $responseId, $questionId)
    {
        $answerText = '';
        $answerValue = $selectedValue;
        $score = null;
        // Handle different option formats
        if (isset($question['options']) || isset($question['option'])) {
            $options = isset($question['options']) ? $question['options'] : $question['option'];
            foreach ($options as $key => $option) {
                // Check if this is the selected option
                $isSelected = false;

                if (is_array($option)) {
                    // Object format with text and value
                    if (isset($option['value']) && $option['value'] == $selectedValue) {
                        $isSelected = true;
                        $answerText = $option['text'] ?? '';
                    } elseif (is_numeric($key) && $key == $selectedValue) {
                        $isSelected = true;
                        $answerText = $option['text'] ?? '';
                    }
                } else {
                    // String format
                    if (is_numeric($key) && $key == $selectedValue) {
                        $isSelected = true;
                        $answerText = $option;
                    }
                }

                if ($isSelected) {
                    // Extract score from parentheses in text
                    $textToParse = is_array($option) ? ($option['text'] ?? '') : $option;
                    if (preg_match('/\((\d+)\)/', $textToParse, $matches)) {
                        $score = (int)$matches[1];
                    }
                    break;
                }
            }
        } else {
            $answer = SurveyAnswer::where('response_id', $responseId)->where('question_id', $question['optionsReferer'])->first();

            if ($answer) {
                $options = json_decode($answer->answer, true);
                $answerText = isset($options[$answerValue]) ? $options[$answerValue] : null;

                // Handle case where the option is an array (from multiText referer)
                if (is_array($answerText)) {
                    // Use the first value of the array as the answer text
                    $answerText = reset($answerText);
                }
            }
        }

        return [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => $answerText,
            'value' => $answerValue,
            'score' => $score
        ];
    }

    /**
     * Process multiple choice answer to extract text, value, and score
     */
    private function processMultipleChoiceAnswer($question, $selectedValues, $responseId, $questionId)
    {
        $answerTexts = [];
        $answerValues = [];
        $scores = [];

        // Decode JSON string to array if needed
        if (is_string($selectedValues)) {
            $decoded = json_decode($selectedValues, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $selectedValues = $decoded;
            }
        }

        // Ensure selectedValues is an array
        if (!is_array($selectedValues)) {
            $selectedValues = [$selectedValues];
        }
        // Handle different option formats
        if (isset($question['options']) || isset($question['option'])) {
            $options = isset($question['options']) ? $question['options'] : $question['option'];

            foreach ($selectedValues as $selectedValue) {
                foreach ($options as $key => $option) {
                    $isSelected = false;
                    $answerText = '';
                    $score = null;

                    if (is_array($option)) {
                        // Object format with text and value
                        if (isset($option['value']) && $option['value'] == $selectedValue) {
                            $isSelected = true;
                            $answerText = $option['text'] ?? '';
                        } elseif (is_numeric($key) && $key == $selectedValue) {
                            $isSelected = true;
                            $answerText = $option['text'] ?? '';
                        }
                    } else {
                        // String format
                        if (is_numeric($key) && $key == $selectedValue) {
                            $isSelected = true;
                            $answerText = $option;
                        }
                    }

                    if ($isSelected) {
                        // Extract score from parentheses in text
                        $textToParse = is_array($option) ? ($option['text'] ?? '') : $option;
                        if (preg_match('/\((\d+)\)/', $textToParse, $matches)) {
                            $score = (int)$matches[1];
                        }

                        $answerTexts[] = $answerText;
                        $answerValues[] = $selectedValue;
                        $scores[] = $score;
                        break;
                    }
                }
            }
        } else {
            $answer = SurveyAnswer::where('response_id', $responseId)
                ->where('question_id', $question['optionsReferer'])
                ->first();
            $options = json_decode($answer->answer);

            $answerTexts = array_intersect_key($options, array_flip($selectedValues));
        }

        // Sum the scores, ignoring nulls
        $totalScore = 0;
        foreach ($scores as $s) {
            if (is_numeric($s)) {
                $totalScore += $s;
            }
        }
        return [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => json_encode($answerTexts),
            'value' => json_encode($selectedValues),
            'score' => $totalScore
        ];
    }

    public function results($section)
    {
        $response = SurveyResponse::with('scores')
            ->where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        // Calculate scores (including subsection scores)

        $this->calculateScore($response, $section, $surveyData);

        // Calculate subsection scores if section has subsections
        $subsectionScores = [];
        $hasSubsections = isset($sectionData['subsections']) && !empty($sectionData['subsections']);

        if ($hasSubsections) {
            $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
        }

        return view('survey.results-enhanced', [
            'section' => $section,
            'response' => $response,
            'sectionData' => $sectionData,
            'subsectionScores' => $subsectionScores,
            'hasSubsections' => $hasSubsections
        ]);
    }

    public function review($section)
    {
        $response = SurveyResponse::with(['answers', 'scores'])
            ->where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        if (!$sectionData) {
            return redirect()->route('dashboard')->with('error', 'Bahagian soal selidik tidak dijumpai.');
        }

        // Check if this section has subsections
        $hasSubsections = isset($sectionData['subsections']) && !empty($sectionData['subsections']);

        $questionsBySubsection = [];
        $subsectionScores = [];

        if ($hasSubsections) {
            // Group questions by subsections
            foreach ($sectionData['subsections'] as $subsection) {
                $questionsBySubsection[$subsection['name']] = [
                    'questions' => $subsection['questions'] ?? [],
                    'score' => null,
                    'category' => null,
                    'recommendation' => null
                ];
            }

            // Get subsection scores if available
            $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);

            // Map scores to subsections
            foreach ($subsectionScores as $scoreData) {
                if (isset($questionsBySubsection[$scoreData['name']])) {
                    $questionsBySubsection[$scoreData['name']]['score'] = $scoreData['score'];
                    $questionsBySubsection[$scoreData['name']]['category'] = $scoreData['category'];
                    $questionsBySubsection[$scoreData['name']]['recommendation'] = $scoreData['recommendation'];
                }
            }
        } else {
            // Handle flat sections without subsections
            $questionsBySubsection['main'] = [
                'questions' => $sectionData['questions'] ?? [],
                'score' => null,
                'category' => null,
                'recommendation' => null
            ];
        }

        return view('survey.review-enhanced', [
            'section' => $section,
            'response' => $response,
            'questionsBySubsection' => $questionsBySubsection,
            'sectionTitle' => $surveyData['sections'][array_search($section, array_column($surveyData['sections'], 'id'))]['title_BM'],
            'hasSubsections' => $hasSubsections,
            'subsectionScores' => $subsectionScores
        ]);
    }

    public function create()
    {
        return view('survey.create');
    }

    public function storeSurvey(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section' => 'required|string|max:10',
            'category' => 'required|string|max:50',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string|max:500',
            'questions.*.type' => 'required|in:single_choice,multiple_choice,text,numeric,rating',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string|max:255'
        ]);

        // In a real application, this would save to database
        // For now, we'll create a JSON file structure

        $surveyData = [
            'title' => $request->title,
            'description' => $request->description,
            'section' => $request->section,
            'category' => $request->category,
            'questions' => []
        ];

        foreach ($request->questions as $index => $questionData) {
            $question = [
                'id' => $index + 1,
                'text' => $questionData['text'],
                'text_BM' => $questionData['text'], // For now, same as text
                'type' => $questionData['type']
            ];

            if (in_array($questionData['type'], ['single_choice', 'multiple_choice']) && isset($questionData['options'])) {
                $question['options'] = $questionData['options'];
            }

            $surveyData['questions'][] = $question;
        }

        // Save to JSON file (in real app, use database)
        $filePath = storage_path('app/survey/custom_' . $request->section . '.json');
        file_put_contents($filePath, json_encode($surveyData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('dashboard')->with('success', 'Soal selidik berjaya dicipta!');
    }

    public function edit($section, $questionId)
    {
        $user = Auth::user();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

        $response = SurveyResponse::where('user_id', $user->id)
            ->where('survey_id', $section)
            ->firstOrFail();

        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        if (!$sectionData) {
            abort(404, 'Bahagian soal selidik tidak dijumpai');
        }

        // Extract all questions including those in subsections
        $questions = collect($this->extractAllQuestions($sectionData));
        $question = $questions->where('id', $questionId)->first();
        if (!$question) {
            abort(404, 'Soalan tidak dijumpai');
        }

        $answer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $questionId)
            ->first();

        return view('survey.edit-enhanced', [
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

        // Get survey data to determine question type
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        if (!$sectionData) {
            return redirect()->route('survey.review', $section)->with('error', 'Bahagian soal selidik tidak dijumpai.');
        }

        // Extract all questions including those in subsections
        $questions = collect($this->extractAllQuestions($sectionData));
        $question = $questions->where('id', $questionId)->first();

        $answer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $questionId)
            ->first();

        $answerData = $this->processAnswerData($question, $request->answer, $response->id, $questionId);

        if ($answer) {
            $answer->update($answerData);
        } else {
            SurveyAnswer::create($answerData);
        }

        return redirect()->route('survey.review', $section)->with('success', 'Jawapan berjaya dikemaskini');
    }

    private function calculateProgress($answered, $allQuestions)
    {
        $total = count($allQuestions);
        $answeredCount = count($answered);
        return $total > 0 ? round(($answeredCount / $total) * 100) : 0;
    }

    /**
     * Extract all questions from a section, including those in subsections
     */
    private function extractAllQuestions($sectionData)
    {
        $questions = [];

        // Get regular questions
        if (isset($sectionData['questions']) && !empty($sectionData['questions'])) {
            $questions = $sectionData['questions'];
        }

        // Handle subsection questions
        if (isset($sectionData['subsections']) && !empty($sectionData['subsections'])) {
            foreach ($sectionData['subsections'] as $subsection) {
                if (isset($subsection['questions']) && !empty($subsection['questions'])) {
                    foreach ($subsection['questions'] as $question) {
                        $questions[] = $question;
                    }
                }
            }
        }

        return $questions;
    }

    private function calculateScore($response, $section, $surveyData)
    {
        // Skip score calculation for sections I, J, and K
        $excludedSections = ['I', 'J', 'K'];
        if (in_array($section, $excludedSections)) {
            return;
        }

        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        if (isset($sectionData['subsections']) && !empty($sectionData['subsections'])) {
            // Calculate subsection scores
            $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
            $this->subsectionScoreService->updateSubsectionScores($response, $subsectionScores);

            // Special handling for Section D overall score calculation
            if ($section === 'D') {
                $this->calculateSectionDOverallScore($response, $subsectionScores);
            }
        } else {
            // Special handling for Section K (IPPT) - now excluded above
            // Fallback to old total score calculation for other sections
            $answers = $response->answers()->get();

            $totalScore = 0;
            $category = '';
            $recommendation = '';

            foreach ($answers as $answer) {
                if ($answer->score !== null) {
                    $totalScore += (int)$answer->score;
                }
            }
            if (isset($sectionData['scoring']['ranges']) || isset($sectionData['scoring']['interpretation'])) {
                $ranges = isset($sectionData['scoring']['ranges']) ? $sectionData['scoring']['ranges'] : $sectionData['scoring']['interpretation'];
                foreach ($ranges as $range) {
                    if (isset($sectionData['scoring']['ranges']))
                        list($min, $max) = explode('-', $range['score']);
                    else
                        list($min, $max) = explode('-', $range['range']);
                    if ($totalScore >= $min && $totalScore <= $max) {
                        $category = $range['category'];
                        $recommendation = $sectionData['scoring']['recommendations'][$category] ?? '';
                        break;
                    }
                }
            } else {
                $category = '';
                $recommendation = '';
            }
            $this->scoreService->updateResponseScore($response, $section, $totalScore, $category, $recommendation);
        }
    }

    /**
     * Calculate Section D overall score based on the three subsection scores
     */
    private function calculateSectionDOverallScore($response, $subsectionScores)
    {
        $prestasiTugas = 0;
        $prestasiKontekstual = 0;
        $perilakuTidakProduktif = 0;

        // Extract scores from subsections
        foreach ($subsectionScores as $score) {
            switch ($score['name']) {
                case 'Prestasi Tugas':
                    $prestasiTugas = $score['score'];
                    break;
                case 'Prestasi Kontekstual':
                    $prestasiKontekstual = $score['score'];
                    break;
                case 'Perilaku Kerja Tidak Produktif':
                    $perilakuTidakProduktif = $score['score'];
                    break;
            }
        }

        // Calculate overall score: (prestasi_tugas + prestasi_kontekstual + perilaku_tidak_produktif) / 3
        // $overallScore = round(($prestasiTugas + $prestasiKontekstual + $perilakuTidakProduktif) / 3, 2);

        // Store the overall score as a separate record
        // $this->scoreService->updateResponseScore(
        //     $response,
        //     'D_overall',
        //     $overallScore,
        //     'Section D Overall',
        //     'JUMLAH SKOR KESELURUHAN: ' . $overallScore
        // );
    }

    /**
     * Calculate IPPT (Individual Physical Proficiency Test) score for Section K
     */
    private function calculateIPPTScore($response, $sectionData)
    {
        $answers = $response->answers()->get();

        // For IPPT, we calculate a composite score based on all physical tests
        $totalTests = 0;
        $completedTests = 0;
        $averagePerformance = 0;

        foreach ($answers as $answer) {
            if ($answer->value !== null && $answer->value > 0) {
                $completedTests++;
                // For demonstration, we'll use a simple scoring system
                // In a real implementation, this would use standardized fitness scoring tables
                $averagePerformance += $this->calculateIndividualTestScore($answer->question_id, $answer->value);
            }
            $totalTests++;
        }

        // Calculate overall IPPT score as percentage
        $totalScore = $completedTests > 0 ? round(($averagePerformance / $completedTests), 2) : 0;

        // Determine category based on score
        $category = '';
        $recommendation = '';

        if (isset($sectionData['scoring']['interpretation'])) {
            foreach ($sectionData['scoring']['interpretation'] as $range) {
                list($min, $max) = explode('-', $range['range']);
                if ($totalScore >= $min && ($max == '100000' || $totalScore <= $max)) {
                    $category = $range['category'];
                    $recommendation = $sectionData['scoring']['recommendations'][$category] ?? '';
                    break;
                }
            }
        }

        $this->scoreService->updateResponseScore($response, 'K', $totalScore, $category, $recommendation);
    }

    /**
     * Calculate individual test score for IPPT components
     */
    private function calculateIndividualTestScore($questionId, $value)
    {
        // Simplified scoring system - in reality this would use official IPPT scoring tables
        // This is a basic implementation for demonstration
        switch ($questionId) {
            case 'K1': // Sit-ups
                if ($value >= 45) return 85;
                if ($value >= 35) return 75;
                if ($value >= 25) return 65;
                return 50;

            case 'K2': // Standing jump
                if ($value >= 240) return 85;
                if ($value >= 220) return 75;
                if ($value >= 200) return 65;
                return 50;

            case 'K3': // Pull-ups (male)
            case 'K4': // Inclined pull-ups (female)
                if ($value >= 12) return 85;
                if ($value >= 8) return 75;
                if ($value >= 4) return 65;
                return 50;

            case 'K5': // Shuttle run (lower is better)
                if ($value <= 15.0) return 85;
                if ($value <= 17.0) return 75;
                if ($value <= 19.0) return 65;
                return 50;

            case 'K6': // 2.4km run (lower is better)
                if ($value <= 10.0) return 85;
                if ($value <= 12.0) return 75;
                if ($value <= 14.0) return 65;
                return 50;

            default:
                return 50;
        }
    }
}

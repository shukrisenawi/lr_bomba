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
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SurveyController extends Controller
{
    protected $scoreService;
    protected $subsectionScoreService;
    protected $partNoScore = ['I', 'J', 'K'];

    public function __construct(ScoreCalculationService $scoreService, \App\Services\SubsectionScoreCalculationService $subsectionScoreService)
    {
        parent::__construct();
        $this->scoreService = $scoreService;
        $this->subsectionScoreService = $subsectionScoreService;
    }

    private function ensureAdminAccess($section)
    {
        if (in_array($section, ['I', 'L'])) {
            $user = Auth::user();
            if ($user && $user->role === 'admin') {
                return null;
            }
            if (session()->get('survey_admin_verified_' . $section) === true) {
                return null;
            }
            return redirect()->route('survey.admin.login-form', $section)
                ->with('error', 'Bahagian ' . $section . ' hanya boleh diakses oleh admin.');
        }
        return null;
    }

    public function showAdminLogin($section)
    {
        if (!in_array($section, ['I', 'L'])) {
            return redirect()->route('survey.show', $section);
        }
        return view('survey.admin-login', ['section' => $section]);
    }

    public function verifyAdminAccess(Request $request, $section)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session()->put('survey_admin_verified_' . $section, true);
            return redirect()->route('survey.show', $section)->with('success', 'Akses admin disahkan.');
        }

        return back()->withErrors(['email' => 'Kelayakan admin tidak sah.'])->withInput();
    }

    public function show($section)
    {
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
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
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
        // Determine if question is optional by checking survey JSON
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();
        $questions = collect($this->extractAllQuestions($sectionData));
        $question = $questions->where('id', $request->question_id)->first();

        $isOptional = isset($question['select']) && $question['select'] === 'optional';

        $validationRules = [
            'question_id' => 'required',
        ];

        // If question is optional or section J, answer can be nullable
        if ($isOptional || $section === 'J') {
            $validationRules['answer'] = 'nullable';
        } else {
            $validationRules['answer'] = 'required';
        }

        $request->validate($validationRules);

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

        // Prevent null answer insertion for optional questions by storing empty string instead
        if ($answerData['answer'] === null) {
            $answerData['answer'] = '';
        }

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
            if ($question['type'] === 'single_choice' || $question['type'] === 'radio_button_image')
                return $this->processRadioButtonAnswer($question, $selectedAnswer, $responseId, $questionId, $question['type']);
            else if ($question['type'] === 'multiple_choice' || $question['type'] === 'select_box_image') {
                return $this->processMultipleChoiceAnswer($question, $selectedAnswer, $responseId, $questionId, $question['type']);
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
            'value' => $selectedValue,
            'score' => $selectedValue // For IPPT, the raw value is the score
        ];
    }
    /**
     * Process radio button answer to extract text, value, and score
     */
    private function processRadioButtonAnswer($question, $selectedValue, $responseId, $questionId, $type)
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
                        $answerText = $option['text'] ?? $option['image'] ?? '';
                    } elseif (is_numeric($key) && $key == $selectedValue) {
                        $isSelected = true;
                        $answerText = $option['text'] ?? $option['image'] ?? '';
                    }
                } else {
                    // String format
                    if (is_numeric($key) && $key == $selectedValue) {
                        $isSelected = true;
                        $answerText = $option;
                    }
                }

                if ($isSelected) {
                    if ($type == "radio_button_image") {
                        $score = $option['score'];
                    } else {
                        // Extract score from parentheses in text
                        $textToParse = is_array($option) ? ($option['text'] ?? '') : $option;
                        if (preg_match('/\((\+?\d+)\)\s*$/', $textToParse, $matches)) {
                            $score = (int)$matches[1];
                        }
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
    private function processMultipleChoiceAnswer($question, $selectedValues, $responseId, $questionId, $type)
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
                            $answerText = $option['text'] ?? $option['image'] ?? '';
                        } elseif (is_numeric($key) && $key == $selectedValue) {
                            $isSelected = true;
                            $answerText = $option['text'] ??  $option['image'] ?? '';
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
                        if ($type == 'select_box_image') {
                            $score = $option['score'];
                        } else {
                            $textToParse = is_array($option) ? ($option['text'] ?? '') : $option;
                            if (preg_match('/\((\+?\d+)\)\s*$/', $textToParse, $matches)) {
                                $score = $matches[1];
                            }
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
            $totalScore += $s;
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
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
        $user_id = Auth::id();
        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        $response = SurveyResponse::with(['scores', 'answers'])
            ->where('user_id', $user_id)
            ->where('survey_id', $section)
            ->firstOrFail();

        if ($section === 'J') {
            $allQuestions = collect($this->extractAllQuestions($sectionData));
            $answers = $response->answers->keyBy('question_id');

            $questionsAndAnswers = $allQuestions->map(function ($question) use ($answers) {
                $answerModel = $answers->get($question['id']);
                $answerText = null;
                if ($answerModel) {
                    $answerText = $answerModel->answer;
                    // Attempt to decode if it's a JSON string
                    $decoded = json_decode($answerText, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $answerText = $decoded;
                    }
                }

                return [
                    'question' => $question,
                    'answer' => $answerText,
                ];
            });

            return view('survey.results-j', [
                'section' => $section,
                'sectionData' => $sectionData,
                'questionsAndAnswers' => $questionsAndAnswers,
            ]);
        }

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
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
        if ($section === 'J') {
            return redirect()->route('survey.results', $section);
        }

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
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
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
        if ($redirect = $this->ensureAdminAccess($section)) {
            return $redirect;
        }
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
        $excludedSections = $this->partNoScore;
        if (in_array($section, $excludedSections)) {
            return;
        }


        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();

        // Special handling for Section D
        if ($section === 'D') {
            $this->calculateSectionDScores($response, $sectionData);
            return;
        }

        // Special handling for Section A (REBA)
        if ($section === 'A') {
            $this->calculateRebaScore($response);
            return;
        }

        if (isset($sectionData['subsections']) && !empty($sectionData['subsections'])) {

            // Calculate subsection scores
            $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
            $this->subsectionScoreService->updateSubsectionScores($response, $subsectionScores);

            // Special handling for Section E overall score calculation
            if ($section === 'E') {
                $this->calculateSectionEOverallScore($response, $subsectionScores);
            }
        }
        // For sections without subsections
        else {
            // Section B has special logic handled by the SubsectionScoreCalculationService.
            if ($section === 'B') {
                $scores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
                $scoreData = $scores[0] ?? null;

                if ($scoreData) {
                    $this->scoreService->updateResponseScore(
                        $response,
                        $section,
                        $scoreData['score'],
                        $scoreData['category'],
                        $scoreData['recommendation']
                    );
                }
            }
            // Fallback to old total score calculation for other sections
            else {
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
    }

    /**
     * Calculate Section E overall score based on the three subsection scores
     */
    private function calculateSectionEOverallScore($response, $subsectionScores)
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
        //     'E_overall',
        //     $overallScore,
        //     'Section E Overall',
        //     'JUMLAH SKOR KESELURUHAN: ' . $overallScore
        // );
    }

    /**
     * Calculate Section D scores
     */
    private function calculateSectionDScores($response, $sectionData)
    {
        $answers = $response->answers()->get()->keyBy('question_id');

        $prestasi_q_ids = ['D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D12'];
        $sikap_q_ids = ['D7', 'D8', 'D9', 'D10', 'D11'];

        $totalScoreKeseluruhan = 0;
        $totalScorePrestasi = 0;
        $totalScoreSikap = 0;

        foreach ($answers as $question_id => $answer) {
            if ($answer->score !== null) {
                $totalScoreKeseluruhan += (int)$answer->score;
                if (in_array($question_id, $prestasi_q_ids)) {
                    $totalScorePrestasi += (int)$answer->score;
                }
                if (in_array($question_id, $sikap_q_ids)) {
                    $totalScoreSikap += (int)$answer->score;
                }
            }
        }

        $scoresToCalculate = [
            'Keseluruhan' => $totalScoreKeseluruhan,
            'Prestasi' => $totalScorePrestasi,
            'Sikap' => $totalScoreSikap,
        ];
        foreach ($scoresToCalculate as $type => $score) {
            $category = '';
            $recommendation = '';
            if (isset($sectionData['scoring']['ranges'][$type])) {
                $ranges = $sectionData['scoring']['ranges'][$type];
                foreach ($ranges as $range) {
                    list($min, $max) = explode('-', $range['score']);
                    if ($score >= $min && $score <= $max) {
                        $category = $range['category'];
                        if (isset($sectionData['scoring']['recommendations'][$category])) {
                            $recommendation = $sectionData['scoring']['recommendations'][$category];
                        }
                        break;
                    }
                }
            }

            $this->scoreService->updateResponseScore(
                $response,
                'D_' . $type,
                $score,
                $category,
                $recommendation
            );
        }
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

        $this->scoreService->updateResponseScore($response, 'L', $totalScore, $category, $recommendation);
    }

    /**
     * Calculate individual test score for IPPT components
     */
    private function calculateIndividualTestScore($questionId, $value)
    {
        // Simplified scoring system - in reality this would use official IPPT scoring tables
        // This is a basic implementation for demonstration
        switch ($questionId) {
            case 'L1': // Sit-ups
                if ($value >= 45) return 85;
                if ($value >= 35) return 75;
                if ($value >= 25) return 65;
                return 50;

            case 'L2': // Standing jump
                if ($value >= 240) return 85;
                if ($value >= 220) return 75;
                if ($value >= 200) return 65;
                return 50;

            case 'L3': // Pull-ups (male)
            case 'L4': // Inclined pull-ups (female)
                if ($value >= 12) return 85;
                if ($value >= 8) return 75;
                if ($value >= 4) return 65;
                return 50;

            case 'L5': // Shuttle run (lower is better)
                if ($value <= 15.0) return 85;
                if ($value <= 17.0) return 75;
                if ($value <= 19.0) return 65;
                return 50;

            case 'L6': // 2.4km run (lower is better)
                if ($value <= 10.0) return 85;
                if ($value <= 12.0) return 75;
                if ($value <= 14.0) return 65;
                return 50;

            default:
                return 50;
        }
    }

    /**
     * Calculate final REBA score for Section A
     */
    private function calculateRebaScore(SurveyResponse $response)
    {
        $answers = $response->answers()->get()->keyBy('question_id');

        // TABLE A: Neck, Trunk, Legs
        $neck = $answers->get('A1')->score ?? 0;
        $neck_adj = $answers->get('A1a')->score ?? 0;
        $neck_score = $neck + $neck_adj;

        $trunk = $answers->get('A2')->score ?? 0;
        $trunk_adj = $answers->get('A2a')->score ?? 0;
        $trunk_score = $trunk + $trunk_adj;

        $legs = $answers->get('A3')->score ?? 0;
        $legs_adj = $answers->get('A3a')->score ?? 0;
        $leg_score = $legs + $legs_adj;

        $tableA_score = $this->getRebaTableA_Score($neck_score, $trunk_score, $leg_score);

        $load_force = $answers->get('A4')->score ?? 0;
        $scoreA = $tableA_score + $load_force;

        // TABLE B: Arms and Wrists
        $upper_arm = $answers->get('A5')->score ?? 0;
        $upper_arm_adj = $answers->get('A5a')->score ?? 0;
        $upper_arm_score = $upper_arm + $upper_arm_adj;

        $lower_arm_score = $answers->get('A6')->score ?? 0;

        $wrist = $answers->get('A7')->score ?? 0;
        $wrist_adj = $answers->get('A7a')->score ?? 0;
        $wrist_score = $wrist + $wrist_adj;

        $tableB_score = $this->getRebaTableB_Score($upper_arm_score, $lower_arm_score, $wrist_score);

        $coupling = $answers->get('A8')->score ?? 0;
        $scoreB = $tableB_score + $coupling;

        // TABLE C
        $tableC_score = $this->getRebaTableC_Score($scoreA, $scoreB);

        $activity = $answers->get('A9')->score ?? 0;
        $final_reba_score = $tableC_score + $activity;

        // Determine Category and Recommendation
        list($category, $recommendation) = $this->getRebaInterpretation($final_reba_score);

        // Update score
        $this->scoreService->updateResponseScore(
            $response,
            'Skor REBA Akhir',
            $final_reba_score,
            $category,
            $recommendation
        );
    }

    private function getRebaTableA_Score($neck, $trunk, $legs)
    {
        $table = [
            // Neck Score 1
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                2 => [1 => 2, 2 => 3, 3 => 4, 4 => 5],
                3 => [1 => 3, 2 => 4, 3 => 5, 4 => 6],
                4 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                5 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
            ],
            // Neck Score 2
            2 => [
                1 => [1 => 2, 2 => 3, 3 => 4, 4 => 5],
                2 => [1 => 3, 2 => 4, 3 => 5, 4 => 6],
                3 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                4 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
                5 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
            ],
            // Neck Score 3
            3 => [
                1 => [1 => 3, 2 => 4, 3 => 5, 4 => 6],
                2 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                3 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
                4 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
                5 => [1 => 7, 2 => 8, 3 => 9, 4 => 9],
            ],
        ];
        return $table[$neck][$trunk][$legs] ?? 0;
    }

    private function getRebaTableB_Score($upper_arm, $lower_arm, $wrist)
    {
        $table = [
            // Upper Arm 1
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 2],
                2 => [1 => 2, 2 => 3, 3 => 3],
            ],
            // Upper Arm 2
            2 => [
                1 => [1 => 2, 2 => 3, 3 => 3],
                2 => [1 => 3, 2 => 4, 3 => 4],
            ],
            // Upper Arm 3
            3 => [
                1 => [1 => 3, 2 => 4, 3 => 4],
                2 => [1 => 4, 2 => 5, 3 => 5],
            ],
            // Upper Arm 4
            4 => [
                1 => [1 => 4, 2 => 5, 3 => 5],
                2 => [1 => 5, 2 => 6, 3 => 6],
            ],
            // Upper Arm 5
            5 => [
                1 => [1 => 6, 2 => 7, 3 => 7],
                2 => [1 => 7, 2 => 8, 3 => 8],
            ],
            // Upper Arm 6
            6 => [
                1 => [1 => 7, 2 => 8, 3 => 8],
                2 => [1 => 8, 2 => 9, 3 => 9],
            ],
        ];
        return $table[$upper_arm][$lower_arm][$wrist] ?? 0;
    }

    private function getRebaTableC_Score($scoreA, $scoreB)
    {
        $table = [
            // Score A = 1
            1 => [1 => 1, 2 => 1, 3 => 1, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 5, 9 => 6, 10 => 7, 11 => 7, 12 => 7],
            // Score A = 2
            2 => [1 => 1, 2 => 2, 3 => 2, 4 => 3, 5 => 4, 6 => 4, 7 => 5, 8 => 6, 9 => 6, 10 => 7, 11 => 7, 12 => 7],
            // Score A = 3
            3 => [1 => 2, 2 => 3, 3 => 3, 4 => 3, 5 => 4, 6 => 5, 7 => 6, 8 => 7, 9 => 7, 10 => 8, 11 => 8, 12 => 8],
            // Score A = 4
            4 => [1 => 3, 2 => 4, 3 => 4, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 8, 10 => 9, 11 => 9, 12 => 9],
            // Score A = 5
            5 => [1 => 4, 2 => 4, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 8, 9 => 9, 10 => 9, 11 => 9, 12 => 9],
            // Score A = 6
            6 => [1 => 6, 2 => 6, 3 => 6, 4 => 7, 5 => 8, 6 => 8, 7 => 9, 8 => 9, 9 => 10, 10 => 10, 11 => 10, 12 => 10],
            // Score A = 7
            7 => [1 => 7, 2 => 7, 3 => 7, 4 => 8, 5 => 9, 6 => 9, 7 => 9, 8 => 10, 9 => 10, 10 => 11, 11 => 11, 12 => 11],
            // Score A = 8
            8 => [1 => 8, 2 => 8, 3 => 8, 4 => 9, 5 => 10, 6 => 10, 7 => 10, 8 => 10, 9 => 11, 10 => 11, 11 => 11, 12 => 12],
            // Score A = 9
            9 => [1 => 9, 2 => 9, 3 => 9, 4 => 10, 5 => 10, 6 => 10, 7 => 11, 8 => 11, 9 => 11, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 10
            10 => [1 => 10, 2 => 10, 3 => 10, 4 => 11, 5 => 11, 6 => 11, 7 => 11, 8 => 12, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 11
            11 => [1 => 11, 2 => 11, 3 => 11, 4 => 11, 5 => 12, 6 => 12, 7 => 12, 8 => 12, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
            // Score A = 12
            12 => [1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12, 6 => 12, 7 => 12, 8 => 12, 9 => 12, 10 => 12, 11 => 12, 12 => 12],
        ];
        // Ensure scoreB is within the valid range [1, 12]
        $scoreB = max(1, min(12, $scoreB));
        return $table[$scoreA][$scoreB] ?? 0;
    }

    private function getRebaInterpretation($score)
    {
        if ($score == 1) {
            return ['Boleh diabaikan', 'Tiada tindakan diperlukan'];
        } elseif ($score >= 2 && $score <= 3) {
            return ['Risiko Rendah', 'Mungkin perlu ada perubahan'];
        } elseif ($score >= 4 && $score <= 7) {
            return ['Risiko Sederhana', 'Perlu ada perubahan'];
        } elseif ($score >= 8 && $score <= 10) {
            return ['Risiko Tinggi', 'Perlu ada perubahan segera'];
        } elseif ($score >= 11) {
            return ['Risiko Sangat Tinggi', 'Perlu ada perubahan serta-merta'];
        } else {
            return ['Tidak Diketahui', 'Skor tidak sah'];
        }
    }
}

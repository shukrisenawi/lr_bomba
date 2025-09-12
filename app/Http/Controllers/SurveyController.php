<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use App\Services\ScoreCalculationService;
use App\Services\SubsectionScoreCalculationService;
use App\Services\MedianScoreCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as LogFacade;
use App\Models\User;

class SurveyController extends Controller
{
    protected $scoreService;
    protected $subsectionScoreService;
    protected $medianScoreService;
    protected $partNoScore = ['I', 'J', 'K'];

    public function __construct(
        ScoreCalculationService $scoreService,
        \App\Services\SubsectionScoreCalculationService $subsectionScoreService,
        MedianScoreCalculationService $medianScoreService
    ) {
        parent::__construct();
        $this->scoreService = $scoreService;
        $this->subsectionScoreService = $subsectionScoreService;
        $this->medianScoreService = $medianScoreService;
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

        // Check if back navigation is requested
        $isBackNavigation = request()->has('back') && request()->get('back') === 'true';

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

        // Check if next navigation is requested
        $isNextNavigation = request()->has('next') && request()->get('next') === 'true';

        // Debug logging for navigation
        Log::info('Navigation debug', [
            'section' => $section,
            'isBackNavigation' => $isBackNavigation,
            'isNextNavigation' => $isNextNavigation,
            'total_answered' => count($answeredQuestions),
            'all_params' => request()->all()
        ]);

        // Handle navigation state using session
        $sessionKey = 'survey_' . $section . '_navigation_state';
        $navigationState = session($sessionKey, ['mode' => 'forward', 'answered_index' => -1]);

        // Debug current navigation state
        Log::info('Current navigation state', [
            'mode' => $navigationState['mode'],
            'answered_index' => $navigationState['answered_index']
        ]);

        // Find current question based on navigation type
        $currentQuestion = null;
        $unansweredQuestions = [];

        if ($isBackNavigation && !empty($answeredQuestions)) {
            Log::info('Processing back navigation');
            // For back navigation, move to previous answered question
            if ($navigationState['mode'] === 'forward') {
                // Switching from forward to back mode, start from last answered
                $navigationState['mode'] = 'back';
                $navigationState['answered_index'] = count($answeredQuestions) - 1;
                Log::info('Switched to back mode, starting from last answered', ['index' => $navigationState['answered_index']]);
            } elseif ($navigationState['answered_index'] > 0) {
                // Move to previous answered question
                $navigationState['answered_index']--;
                Log::info('Moved to previous answered question', ['new_index' => $navigationState['answered_index']]);
            }
            // If already at first answered question (index 0), stay there

            // Get the question at the current index from answered questions
            if ($navigationState['answered_index'] >= 0 && $navigationState['answered_index'] < count($answeredQuestions)) {
                $targetQuestionId = $answeredQuestions[$navigationState['answered_index']];
                Log::info('Target question ID for back navigation', ['question_id' => $targetQuestionId]);
                foreach ($questions as $question) {
                    if ($question['id'] === $targetQuestionId) {
                        $currentQuestion = $question;
                        Log::info('Found current question for back navigation', ['question' => $question['id']]);
                        break;
                    }
                }
            }
        } elseif ($isNextNavigation && !empty($answeredQuestions)) {
            Log::info('Processing next navigation');
            // For next navigation within answered questions
            if ($navigationState['mode'] === 'back') {
                Log::info('In back mode, processing next navigation');
                // Move to next answered question
                if ($navigationState['answered_index'] < count($answeredQuestions) - 1) {
                    $navigationState['answered_index']++;
                    Log::info('Moved to next answered question', ['new_index' => $navigationState['answered_index']]);
                } else {
                    // If at the end of answered questions, switch to forward mode
                    $navigationState['mode'] = 'forward';
                    $navigationState['answered_index'] = -1;
                    Log::info('Reached end of answered questions, switching to forward mode');
                    // Find next unanswered question
                    foreach ($questions as $question) {
                        if (!in_array($question['id'], $answeredQuestions)) {
                            $currentQuestion = $question;
                            Log::info('Found next unanswered question', ['question' => $question['id']]);
                            break;
                        }
                    }
                }

                if ($navigationState['mode'] === 'back' && $navigationState['answered_index'] >= 0 && $navigationState['answered_index'] < count($answeredQuestions)) {
                    $targetQuestionId = $answeredQuestions[$navigationState['answered_index']];
                    Log::info('Target question ID for next navigation in back mode', ['question_id' => $targetQuestionId]);
                    foreach ($questions as $question) {
                        if ($question['id'] === $targetQuestionId) {
                            $currentQuestion = $question;
                            Log::info('Found current question for next navigation', ['question' => $question['id']]);
                            break;
                        }
                    }
                }
            } else {
                Log::info('Next navigation requested but not in back mode');
            }
        } else {
            // Normal navigation: Find next unanswered question
            foreach ($questions as $question) {
                if (!in_array($question['id'], $answeredQuestions)) {
                    $unansweredQuestions[] = $question;
                    if (!$currentQuestion) {
                        $currentQuestion = $question;
                        // Reset to forward mode when moving to unanswered questions
                        $navigationState['mode'] = 'forward';
                        $navigationState['answered_index'] = -1;
                    }
                }
            }
        }

        // Store navigation state in session
        session([$sessionKey => $navigationState]);

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

        // Calculate navigation variables
        $currentQuestionAnswered = $answer && !empty($answer->answer);
        $totalRemaining = count($questions) - count($answeredQuestions);
        $canGoNext = $currentQuestionAnswered && $totalRemaining > 0;

        Log::info('Question navigation debug', [
            'question_id' => $currentQuestion['id'],
            'answer_exists' => $answer !== null,
            'answer_value' => $answer ? $answer->answer : null,
            'currentQuestionAnswered' => $currentQuestionAnswered,
            'totalRemaining' => $totalRemaining,
            'canGoNext' => $canGoNext
        ]);

        return view('survey.question-beautiful', [
            'section' => $section,
            'question' => $currentQuestion,
            'answer' => $answer,
            'progress' => $this->calculateProgress($answeredQuestions, $questions),
            'sectionTitle' => $sectionTitle,
            'debug_info' => config('app.debug') ? [
                'total_questions' => count($questions),
                'answered' => count($answeredQuestions),
                'remaining' => count($unansweredQuestions),
                'current_question_answered' => $currentQuestionAnswered,
                'can_go_next' => $canGoNext
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

        // Handle videoImage type validation
        if ($question && $question['type'] === 'videoImage') {
            $limit = $question['limit'] ?? 5;
            $validationRules['files'] = 'nullable|array|max:' . $limit;
            $validationRules['files.*'] = 'file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,wmv|max:20480'; // 20MB max

            Log::info('VideoImage validation rules:', [
                'rules' => $validationRules,
                'request_files' => $request->hasFile('files'),
                'all_input' => $request->all()
            ]);
        } else {
            // If question is optional or section J, answer can be nullable
            if ($isOptional || $section === 'J') {
                $validationRules['answer'] = 'nullable';
            } else {
                $validationRules['answer'] = 'required';
            }
        }

        try {
            $request->validate($validationRules);
            Log::info('Validation passed', ['rules' => $validationRules]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'validation_rules' => $validationRules
            ]);
            throw $e;
        }

        $response = SurveyResponse::where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        // Handle videoImage file uploads
        if ($question && $question['type'] === 'videoImage') {
            return $this->handleVideoImageUpload($request, $response, $question);
        }

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

        // Debug: Log the request data
        Log::info('Survey store request', [
            'question_id' => $request->question_id,
            'answer' => $request->answer,
            'has_navigation_url' => $request->has('navigation_url'),
            'navigation_url' => $request->navigation_url,
            'all_data' => $request->all()
        ]);

        // Check if this is an update or new insert
        $existingAnswer = SurveyAnswer::where('response_id', $response->id)
            ->where('question_id', $request->question_id)
            ->first();

        $isUpdate = $existingAnswer !== null;

        // Update existing answer or create new one
        $surveyAnswer = SurveyAnswer::updateOrCreate(
            [
                'response_id' => $response->id,
                'question_id' => $request->question_id
            ],
            $answerData
        );

        // Debug: Log the saved answer
        Log::info('Answer saved/updated', [
            'answer_id' => $surveyAnswer->id,
            'question_id' => $surveyAnswer->question_id,
            'answer' => $surveyAnswer->answer,
            'value' => $surveyAnswer->value,
            'is_update' => $isUpdate
        ]);

        // Check if navigation URL is provided (for auto-save navigation)
        if ($request->has('navigation_url') && !empty($request->navigation_url)) {
            // Log successful save with navigation
            Log::info('Answer saved successfully with navigation', [
                'question_id' => $request->question_id,
                'navigation_url' => $request->navigation_url
            ]);
            return redirect($request->navigation_url);
        }

        return redirect()->route('survey.show', $section)->with('answer_saved', [
            'is_update' => $isUpdate,
            'question_id' => $request->question_id
        ]);
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
            } else if ($question['type'] === 'videoImage') {
                // videoImage answers are already handled in handleVideoImageUpload
                // This case should not be reached, but included for completeness
                $baseData['answer'] = $selectedAnswer;
                $baseData['value'] = $selectedAnswer;
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

        // Get median scores for Section C if this is section C
        $medianScores = [];
        if ($section === 'C') {
            $medianScores = $this->medianScoreService->getMedianScores();
        }

        return view('survey.results-enhanced', [
            'section' => $section,
            'response' => $response,
            'sectionData' => $sectionData,
            'subsectionScores' => $subsectionScores,
            'hasSubsections' => $hasSubsections,
            'medianScores' => $medianScores
        ]);
    }

    public function overallResults()
    {
        try {
            $user_id = Auth::id();

            // Check if user is authenticated
            if (!$user_id) {
                return redirect()->route('login')->with('error', 'Sila login terlebih dahulu.');
            }

            $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

            // Get all completed survey responses for the user
            $responses = SurveyResponse::with(['scores', 'answers'])
                ->where('user_id', $user_id)
                ->where('completed', true)
                ->get()
                ->keyBy('survey_id');

            // Get user information from respondents table
            $respondent = \App\Models\Respondent::where('user_id', $user_id)->first();

            // Collect data for each section
            $sectionsData = [];
            $overallStatus = 'TIDAK LENGKAP';

            foreach ($surveyData['sections'] as $sectionData) {
                $section = $sectionData['id'];
                if (isset($responses[$section])) {
                    $response = $responses[$section];

                    // Calculate scores if not already calculated
                    $this->calculateScore($response, $section, $surveyData);

                    // Get subsection scores if available
                    $subsectionScores = [];
                    $hasSubsections = isset($sectionData['subsections']) && !empty($sectionData['subsections']);
                    if ($hasSubsections) {
                        $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
                    }

                    $sectionsData[$section] = [
                        'title' => $sectionData['title_BM'],
                        'response' => $response,
                        'subsectionScores' => $subsectionScores,
                        'hasSubsections' => $hasSubsections,
                        'sectionData' => $sectionData
                    ];
                }
            }

            // Determine overall status
            $totalSections = count($surveyData['sections']);
            $completedSections = count($sectionsData);
            if ($completedSections === $totalSections) {
                $overallStatus = 'LENGKAP';
            } elseif ($completedSections > 0) {
                $overallStatus = 'SEBAHAGIAN LENGKAP';
            }

            return view('survey.overall-results', [
                'sectionsData' => $sectionsData,
                'respondent' => $respondent,
                'overallStatus' => $overallStatus,
                'surveyData' => $surveyData
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in overallResults: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return error view or redirect with error message
            return redirect()->route('dashboard')->with('error', 'Ralat memuat laporan: ' . $e->getMessage());
        }
    }

    public function testOverallResults()
    {
        try {
            // For testing purposes, use a hardcoded user ID or get first user
            $user_id = 1; // Assuming user ID 1 exists

            $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);

            // Get all completed survey responses for the user
            $responses = SurveyResponse::with(['scores', 'answers'])
                ->where('user_id', $user_id)
                ->where('completed', true)
                ->get()
                ->keyBy('survey_id');

            // Get user information from respondents table
            $respondent = \App\Models\Respondent::where('user_id', $user_id)->first();

            // Collect data for each section
            $sectionsData = [];
            $overallStatus = 'TIDAK LENGKAP';

            foreach ($surveyData['sections'] as $sectionData) {
                $section = $sectionData['id'];
                if (isset($responses[$section])) {
                    $response = $responses[$section];

                    // Calculate scores if not already calculated
                    $this->calculateScore($response, $section, $surveyData);

                    // Get subsection scores if available
                    $subsectionScores = [];
                    $hasSubsections = isset($sectionData['subsections']) && !empty($sectionData['subsections']);
                    if ($hasSubsections) {
                        $subsectionScores = $this->subsectionScoreService->calculateSubsectionScores($response, $sectionData);
                    }

                    $sectionsData[$section] = [
                        'title' => $sectionData['title_BM'],
                        'response' => $response,
                        'subsectionScores' => $subsectionScores,
                        'hasSubsections' => $hasSubsections,
                        'sectionData' => $sectionData
                    ];
                }
            }

            // Determine overall status
            $totalSections = count($surveyData['sections']);
            $completedSections = count($sectionsData);
            if ($completedSections === $totalSections) {
                $overallStatus = 'LENGKAP';
            } elseif ($completedSections > 0) {
                $overallStatus = 'SEBAHAGIAN LENGKAP';
            }

            // Get median scores for Section C
            $medianScores = $this->medianScoreService->getMedianScores();

            return view('survey.overall-results', [
                'sectionsData' => $sectionsData,
                'respondent' => $respondent,
                'overallStatus' => $overallStatus,
                'surveyData' => $surveyData,
                'medianScores' => $medianScores
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
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
            'questions.*.type' => 'required|in:single_choice,multiple_choice,text,numeric,rating,videoImage',
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

    /**
     * Handle videoImage file uploads
     */
    private function handleVideoImageUpload(Request $request, $response, $question)
    {
        $uploadedFiles = [];

        // Debug: Log the request data
        Log::info('VideoImage Upload Debug:', [
            'has_files' => $request->hasFile('files'),
            'all_files' => $request->allFiles(),
            'question_id' => $question['id'],
            'response_id' => $response->id
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                try {
                    // Check if file is valid before processing
                    if (!$file->isValid()) {
                        Log::error('Invalid file upload:', ['error' => $file->getErrorMessage()]);
                        continue;
                    }

                    // Get file info before moving (to avoid stat failed error)
                    $originalName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $mimeType = $file->getMimeType();
                    $extension = $file->getClientOriginalExtension();

                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $extension;

                    // Ensure upload directory exists
                    $uploadPath = public_path('upload');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    // Move file to public/upload directory
                    $moved = $file->move($uploadPath, $filename);

                    if ($moved) {
                        // Store file info
                        $uploadedFiles[] = [
                            'filename' => $filename,
                            'original_name' => $originalName,
                            'size' => $fileSize,
                            'mime_type' => $mimeType,
                            'url' => asset('upload/' . $filename)
                        ];

                        Log::info('File uploaded successfully:', [
                            'filename' => $filename,
                            'original_name' => $originalName,
                            'size' => $fileSize,
                            'path' => $uploadPath . '/' . $filename
                        ]);
                    } else {
                        Log::error('Failed to move file:', ['filename' => $filename]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing file upload:', [
                        'error' => $e->getMessage(),
                        'file' => $file->getClientOriginalName() ?? 'unknown'
                    ]);
                    continue;
                }
            }
        } else {
            Log::warning('No files found in request for videoImage upload');
        }

        // Store the file information as JSON
        $answerData = [
            'files' => $uploadedFiles,
            'upload_count' => count($uploadedFiles)
        ];

        Log::info('Saving answer data:', [
            'answer_data' => $answerData,
            'response_id' => $response->id,
            'question_id' => $question['id']
        ]);

        try {
            $surveyAnswer = SurveyAnswer::updateOrCreate(
                [
                    'response_id' => $response->id,
                    'question_id' => $question['id']
                ],
                [
                    'answer' => json_encode($answerData),
                    'value' => json_encode($answerData)
                ]
            );

            Log::info('Answer saved successfully:', ['answer_id' => $surveyAnswer->id]);

            $successMessage = count($uploadedFiles) > 0
                ? 'Fail berjaya dimuat naik! ' . count($uploadedFiles) . ' fail telah disimpan.'
                : 'Jawapan disimpan (tiada fail dimuat naik).';

            return redirect()->route('survey.show', $response->survey_id)
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            Log::error('Error saving answer:', ['error' => $e->getMessage()]);
            return redirect()->route('survey.show', $response->survey_id)
                ->with('error', 'Ralat menyimpan fail: ' . $e->getMessage());
        }
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

            // Special handling for Section C median score calculation
            if ($section === 'C') {
                $this->calculateSectionCMedianScores();
            }

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
     * Calculate median scores for Section C subsections
     */
    private function calculateSectionCMedianScores()
    {
        try {
            // Calculate median scores for all subsections in Section C
            $medianScores = $this->medianScoreService->calculateMedianScoresForSectionC();

            // Save the median scores to database
            $this->medianScoreService->saveMedianScores($medianScores);

            Log::info('Median scores calculated and saved for Section C', $medianScores);
        } catch (\Exception $e) {
            Log::error('Error calculating median scores for Section C: ' . $e->getMessage());
        }
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

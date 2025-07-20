<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
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
        $questions = array_map(function ($question) {
            // Handle the case where "option" is used instead of "options"
            if (isset($question['option']) && !isset($question['options'])) {
                $question['options'] = $question['option'];
                unset($question['option']);
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

        return view('survey.question-beautiful', [
            'section' => $section,
            'question' => $currentQuestion,
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


        $answerData = $this->processAnswerData($question, $request->answer, $response->id, $request->question_id);


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

        // Handle radio button questions (single_choice)
        if ($question && $question['type'] === 'single_choice') {
            return $this->processRadioButtonAnswer($question, $selectedAnswer, $responseId, $questionId);
        }

        // For other question types, just store the answer as-is
        return $baseData;
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
                    } elseif ($option == $selectedValue) {
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
        }

        return [
            'response_id' => $responseId,
            'question_id' => $questionId,
            'answer' => $answerText,
            'value' => $answerValue,
            'score' => $score
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

        return view('survey.results-enhanced', [
            'section' => $section,
            'response' => $response,
            'sectionData' => $sectionData
        ]);
    }

    public function review($section)
    {
        $response = SurveyResponse::with('answers')
            ->where('user_id', Auth::id())
            ->where('survey_id', $section)
            ->firstOrFail();

        $surveyData = json_decode(file_get_contents(storage_path('app/survey/1st_draft.json')), true);
        $questions = collect($surveyData['sections'])->where('id', $section)->first()['questions'] ?? [];
        $questions = collect($questions); // Convert array to collection

        return view('survey.review-enhanced', [
            'section' => $section,
            'response' => $response,
            'questions' => $questions,
            'sectionTitle' => $surveyData['sections'][array_search($section, array_column($surveyData['sections'], 'id'))]['title_BM']
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
        $sectionData = collect($surveyData['sections'])->where('id', $section)->first();
        $answers = $response->answers()->get();

        $score = 0;
        $maxPossibleScore = 0;
        $category = '';
        $recommendation = '';

        // Calculate actual score and max possible score
        foreach ($answers as $answer) {
            // Extract numeric value from answer if available
            if ($answer->score !== null) {
                $score += (int)$answer->score;
            } elseif (preg_match('/\((\d+)\)/', $answer->answer, $matches)) {
                $score += (int)$matches[1];
            } elseif (is_numeric($answer->answer)) {
                $score += (int)$answer->answer;
            }
        }

        // Calculate max possible score for this section
        $questions = $this->extractAllQuestions($sectionData);
        foreach ($questions as $question) {
            if (isset($question['options'])) {
                $maxOptionScore = 0;
                foreach ($question['options'] as $option) {
                    if (is_array($option) && isset($option['value'])) {
                        $maxOptionScore = max($maxOptionScore, (int)$option['value']);
                    } elseif (preg_match('/\((\d+)\)/', $option, $matches)) {
                        $maxOptionScore = max($maxOptionScore, (int)$matches[1]);
                    }
                }
                $maxPossibleScore += $maxOptionScore;
            }
        }

        // Normalize score to 100-point scale if maxPossibleScore > 0
        $normalizedScore = $maxPossibleScore > 0 ? round(($score / $maxPossibleScore) * 100) : 0;

        // Determine category based on score ranges
        if (isset($sectionData['scoring']['ranges'])) {
            foreach ($sectionData['scoring']['ranges'] as $range) {
                list($min, $max) = explode('-', $range['score']);
                if ($normalizedScore >= $min && $normalizedScore <= $max) {
                    $category = $range['category'];
                    $recommendation = $sectionData['scoring']['recommendations'][$category];
                    break;
                }
            }
        }

        // Save the score
        SurveyScore::create([
            'response_id' => $response->id,
            'section' => $section,
            'score' => $normalizedScore,
            'category' => $category,
            'recommendation' => $recommendation
        ]);
    }
}

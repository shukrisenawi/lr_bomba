<?php

// Test script to verify radio_button_image scoring functionality
require_once 'app/Helpers/survey_helper.php';

// Test data for radio_button_image questions
$testQuestion = [
    'type' => 'radio_button_image',
    'id' => 'test1',
    'text' => 'Test radio button image question',
    'options' => [
        [
            'value' => '1',
            'image' => '1a.png'
        ],
        [
            'value' => '2',
            'image' => '1b.png'
        ],
        [
            'value' => '3',
            'image' => '1c.png'
        ]
    ]
];

// Test cases
$testCases = [
    [
        'answer' => '1',
        'expected_score' => 1,
        'description' => 'Should return 1 for value 1'
    ],
    [
        'answer' => '2',
        'expected_score' => 2,
        'description' => 'Should return 2 for value 2'
    ],
    [
        'answer' => '3',
        'expected_score' => 3,
        'description' => 'Should return 3 for value 3'
    ],
    [
        'answer' => '',
        'expected_score' => 0,
        'description' => 'Should return 0 for empty answer'
    ],
    [
        'answer' => 'invalid',
        'expected_score' => 0,
        'description' => 'Should return 0 for invalid answer'
    ]
];

echo "Testing radio_button_image scoring functionality...\n\n";

foreach ($testCases as $testCase) {
    $score = calculate_question_score($testQuestion, $testCase['answer']);

    if ($score === $testCase['expected_score']) {
        echo "✓ PASS: {$testCase['description']} - Score: {$score}\n";
    } else {
        echo "✗ FAIL: {$testCase['description']} - Expected: {$testCase['expected_score']}, Got: {$score}\n";
    }
}

// Test with actual survey data from 1st_draft.json
echo "\nTesting with actual survey data...\n";

// Load survey data
$surveyData = json_decode(file_get_contents('storage/app/survey/1st_draft.json'), true);

// Find radio_button_image questions in section I (REBA)
$rebaSection = null;
foreach ($surveyData['sections'] as $section) {
    if ($section['id'] === 'I') {
        $rebaSection = $section;
        break;
    }
}

if ($rebaSection) {
    echo "Found REBA section with radio_button_image questions\n";

    // Test a specific radio_button_image question
    $neckQuestion = [
        'type' => 'radio_button_image',
        'options' => [
            ['value' => '1', 'image' => '1a.png'],
            ['value' => '2', 'image' => '1b.png'],
            ['value' => '2', 'image' => '1c.png']
        ]
    ];

    $testScore = calculate_question_score($neckQuestion, '1');
    echo "Neck position score for value 1: {$testScore}\n";

    $testScore = calculate_question_score($neckQuestion, '2');
    echo "Neck position score for value 2: {$testScore}\n";
}

echo "\nTesting completed.\n";

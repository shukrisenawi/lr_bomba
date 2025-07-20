<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Respondent;

// Load Laravel environment
$app = require_once 'bootstrap/app.php';

// Get the respondent for user_id=1
$respondent = Respondent::where('user_id', 1)->first();

if ($respondent) {
    echo "Respondent found for user_id=1:\n";
    echo "ID: " . $respondent->id . "\n";
    echo "User ID: " . $respondent->user_id . "\n";
    echo "Phone: " . $respondent->phone_number . "\n";
    echo "Age: " . $respondent->age . "\n";
    echo "Gender: " . $respondent->gender . "\n";
    echo "Location: " . $respondent->location . "\n";
    echo "Position: " . $respondent->position . "\n";
    echo "Created: " . $respondent->created_at . "\n";
} else {
    echo "No respondent found for user_id=1\n";
}

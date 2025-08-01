<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Laluan untuk pendaftaran
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return view('index-new');
        // return redirect()->route('register.create');
    }
})->name('home');
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'storeConsent'])->name('register.store-consent');
Route::get('/demography', [RegisterController::class, 'showDemographyForm'])->name('register.demography');
Route::post('/demography', [RegisterController::class, 'storeDemography'])->name('register.store-demography');

Route::middleware('guest')->group(
    function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    }
);
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('survey')->group(function () {
        Route::get('/create', [SurveyController::class, 'create'])->name('survey.create');
        Route::post('/create', [SurveyController::class, 'storeSurvey'])->name('survey.store-survey');
        Route::get('/{section}', [SurveyController::class, 'show'])->name('survey.show');
        Route::post('/{section}', [SurveyController::class, 'store'])->name('survey.store');
        Route::get('/{section}/results', [SurveyController::class, 'results'])->name('survey.results');
        Route::get('/{section}/review', [SurveyController::class, 'review'])->name('survey.review');
        Route::get('/{section}/edit/{question}', [SurveyController::class, 'edit'])->name('survey.edit');
        Route::put('/{section}/update/{question}', [SurveyController::class, 'update'])->name('survey.update');
    });
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/responders', [AdminController::class, 'responders'])->name('admin.responders');
        Route::get('/responders/{id}', [AdminController::class, 'showResponder'])->name('admin.responder.show');
    });
});

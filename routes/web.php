<?php

use App\Http\Controllers\Part1Controller;
use App\Http\Controllers\Part2Controller;
use App\Http\Controllers\Part3Controller;
use App\Http\Controllers\Part4Controller;
use App\Http\Controllers\Part5Controller;
use App\Http\Controllers\Part6Controller;
use App\Http\Controllers\Part7Controller;
use App\Http\Controllers\Part8Controller;
use App\Http\Controllers\Part9Controller;
use App\Http\Controllers\Part10Controller;
use App\Http\Controllers\Part11Controller;
use App\Http\Controllers\Part12Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/part-1', [Part1Controller::class, 'index'])->name('part-1');
Route::get('/part-2', [Part2Controller::class, 'index'])->name('part-2');
Route::get('/part-3', [Part3Controller::class, 'index'])->name('part-3');
Route::get('/part-4', [Part4Controller::class, 'index'])->name('part-4');
Route::get('/part-5', [Part5Controller::class, 'index'])->name('part-5');
Route::get('/part-6', [Part6Controller::class, 'index'])->name('part-6');
Route::get('/part-7', [Part7Controller::class, 'index'])->name('part-7');
Route::get('/part-8', [Part8Controller::class, 'index'])->name('part-8');
Route::get('/part-9', [Part9Controller::class, 'index'])->name('part-9');
Route::get('/part-10', [Part10Controller::class, 'index'])->name('part-10');
Route::get('/part-11', [Part11Controller::class, 'index'])->name('part-11');
Route::get('/part-12', [Part12Controller::class, 'index'])->name('part-12');

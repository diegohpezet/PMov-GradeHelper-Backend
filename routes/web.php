<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('courses', CourseController::class);
Route::resource('exercises', ExerciseController::class);

Route::get('/', function () {
    return Inertia::render('Welcome');
});
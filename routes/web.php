<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('courses', CourseController::class);

Route::get('/', function () {
    return Inertia::render('Welcome');
});
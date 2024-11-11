<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GithubAuthController;

Route::get('/auth/github', [GithubAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [GithubAuthController::class, 'handleGithubCallback']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('courses', CourseController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('exercises', ExerciseController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('grades', GradeController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('students', StudentController::class)->except(['store', 'update', 'destroy']);

    Route::middleware(['admin'])->group(function () {
        Route::apiResource('courses', CourseController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('exercises', ExerciseController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('grades', GradeController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('students', StudentController::class)->only(['store', 'update', 'destroy']);
    });
});

// Additional routes for grades
Route::get('grades/student/{student}', [GradeController::class, 'gradesByStudent']);
Route::get('grades/exercise/{exercise}', [GradeController::class, 'gradesByExercise']);
Route::get('grades/student/{student}/exercise/{exercise}', [GradeController::class, 'gradesByStudentAndExercise']);

// God mode
Route::middleware(['auth:sanctum'])->get('giveMePower', function (Request $request) {
    $request->user()->assignRole('admin');
    return response()->json(['success' => true]);
});
// Disable god mode
Route::middleware(['auth:sanctum'])->get('iGotFired', function (Request $request) {
    $request->user()->removeRole('admin');
    return response()->json(['success' => true]);
});

// Additional routes for grades
Route::get('grades/student/{student}', [GradeController::class, 'gradesByStudent']);
Route::get('grades/exercise/{exercise}', [GradeController::class, 'gradesByExercise']);
Route::get('grades/student/{student}/exercise/{exercise}', [GradeController::class, 'gradesByStudentAndExercise']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

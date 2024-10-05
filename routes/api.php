<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GithubAuthController;

Route::get('/auth/github', [GithubAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [GithubAuthController::class, 'handleGithubCallback']);

Route::apiResource('courses', CourseController::class);
Route::apiResource('exercises', ExerciseController::class);
Route::apiResource('grades', GradeController::class);

// Additional routes for grades
Route::get('grades/student/{studentId}', [GradeController::class, 'gradesByStudent']);
Route::get('grades/exercise/{exerciseId}', [GradeController::class, 'gradesByExercise']);
Route::get('grades/student/{studentId}/exercise/{exerciseId}', [GradeController::class, 'gradesByStudentAndExercise']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

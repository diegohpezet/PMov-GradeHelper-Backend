<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GithubAuthController;

Route::get('/auth/github', [GithubAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [GithubAuthController::class, 'handleGithubCallback']);

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('courses', CourseController::class)->middleware('auth:sanctum');
Route::apiResource('exercises', ExerciseController::class)->middleware('auth:sanctum');
Route::apiResource('grades', GradeController::class)->middleware('auth:sanctum');

// Additional routes for grades
Route::get('grades/student/{student}', [GradeController::class, 'gradesByStudent']);
Route::get('grades/exercise/{exercise}', [GradeController::class, 'gradesByExercise']);
Route::get('grades/student/{student}/exercise/{exercise}', [GradeController::class, 'gradesByStudentAndExercise']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

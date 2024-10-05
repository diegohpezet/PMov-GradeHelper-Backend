<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GithubAuthController;

Route::get('/auth/github', [GithubAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [GithubAuthController::class, 'handleGithubCallback']);

Route::apiResource('courses', CourseController::class);
Route::apiResource('exercises', ExerciseController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

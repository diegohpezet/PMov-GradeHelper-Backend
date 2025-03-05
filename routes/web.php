<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        if ($request->user()->isAdmin()) {
            return redirect()->route('courses.index');
        }
        return redirect()->route('home');
    }
    return Inertia::render('Welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('admin')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::resource('exercises', ExerciseController::class);
        Route::resource('students', StudentController::class);
        Route::resource('grades', GradesController::class);

        Route::post('attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::delete('attendances', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    });
});

require __DIR__.'/auth.php';

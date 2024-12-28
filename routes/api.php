<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/users', function () {
        $users = User::all()->load('student');

        return response()->json($users);
    });

    Route::put('/students/{student}/users/{user}', function (Student $student, User $user) {
        $student->user_id = $user->id;
        $student->save();

        return response()->json($student);
    });

    Route::delete('/students/{student}/users/{user}', function (Student $student, User $user) {
        if ($student->user_id !== $user->id) {
            return response()->json(['error' => 'Student does not have the specified user'], 400);
        }

        $student->user_id = null;
        $student->save();

        return response()->json($student);
    });
});
<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeFullscreenController extends Controller
{
    public function show(Course $course, Request $request)
    {
        $course->load([
            'exercises',
            'students.grades',
        ]);
        return Inertia::render('GradeFullscreen/GradeFullscreenPage', [
            'course' => $course,
        ]);
    }
}

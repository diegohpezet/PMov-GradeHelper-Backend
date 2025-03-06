<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    $student = $request->user()->student;

    if (!$student) {
      return Inertia::render('Home/HomeView');
    }

    $student->load([
      'course',
      'course.assessments.exercise',
      'course.assessments.grades' => function ($query) use ($student) {
        $query->where('student_id', $student->id);
      },
      'course.assessments.grades.gradeable',
      'course.attendances'
    ]);

    return Inertia::render('Home/HomeView', [
      'student' => $student
    ]);
  }
}

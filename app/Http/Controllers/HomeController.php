<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    $student = $request->user()->student;

    $student->load([
      'course',
      'course.assessments.exercise',
      'course.assessments.gradeables' => function ($query) use ($student) {
        $query->where('student_id', $student->id);
      },
      'course.assessments.gradeables.gradable',
      'course.attendances'
    ]);

    return Inertia::render('Home/HomeView', [
      'student' => $student
    ]);
  }
}

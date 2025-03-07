<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    $student = $request->user()->student;

    $student?->load([
      'grades',
      'attendances',
      'course' => ['exercises', 'attendances'],
    ]);

    return Inertia::render('Home/HomeView', [
      'student' => $student,
    ]);
  }
}

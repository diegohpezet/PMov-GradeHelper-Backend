<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('course')->get();

        return Inertia::render('Students/Index', [
            'students' => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());

        return redirect()->back()->with('success', 'Student created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($studentParam)
    {
        $student = Student::where('id', $studentParam)
        ->orWhere('githubUsername', $studentParam)
        ->with(['course.exercises', 'grades'])
        ->firstOrFail();

        // structure as student.course.exercises.grades
        $gradesByExercise = $student->grades->groupBy('exercise_id');
        $student->course->exercises->map(function ($exercise) use ($gradesByExercise) {
            $exercise['grades'] = $gradesByExercise[$exercise->id] ?? collect();
            return $exercise;
        });

        return Inertia::render('Students/Show', [
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student) {
        return Inertia::render('Students/Edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}

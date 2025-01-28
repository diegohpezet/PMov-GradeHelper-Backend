<?php

namespace App\Http\Controllers;

use App\Enums\Enums\GradeResult;
use App\Models\Exercise;
use App\Models\Grade;
use App\Models\Student;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Mail\ExerciseCorrection;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('grades')->get();
        $exercises = Exercise::all();

        $tableData = $students->map(function ($student) use ($exercises) {
            return $student->transformWithGrades($exercises);
        });

        return Inertia::render('Grades/Index', [
            'exercises' => $exercises,
            'students' => $tableData,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());

        // Send email after creating the grade
        $userToMail = $grade->student->user;
        Mail::to($userToMail->email)->send(new ExerciseCorrection($grade));

        return redirect()->back()->with('success', 'Grade created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return response()->json($grade);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return Inertia::render('Grades/Edit', [
            'grade' => $grade
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\Enums\GradeResult;
use App\Models\Exercise;
use App\Models\Grade;
use App\Models\Student;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
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
            $grades = $exercises->map(function ($exercise) use ($student) {
                $exerciseGrades = $student->grades->where('exercise_id', $exercise->id);

                return [
                    'exercise_id' => $exercise->id,
                    'grades' => $exerciseGrades->map(function ($grade) {
                        return [
                            'id' => $grade->id,
                            'result' => $grade->result,
                            'comment' => $grade->comment,
                            'created_at' => $grade->created_at,
                        ];
                    })->values()->toArray(),
                ];
            });

            return [
                'id' => $student->id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'githubUsername' => $student->githubUsername,
                'grades' => $grades,
            ];
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
        Grade::create($request->validated());

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

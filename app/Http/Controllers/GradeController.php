<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();

        return $grades;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exercise_id' => 'required|exists:exercises,id',
            'score' => 'required|integer',
            'comment' => 'nullable|string|max:255',
        ]);

        $course = Grade::create($request->all());

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return response()->json($grade);
    }

    /**
     * Display the grades for a specific student.
     */
    public function gradesByStudent(Student $student)
    {
        $grades = $student->grades()
            ->with(['exercise'])
            ->get();

        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this student.'], 404);
        }

        return response()->json($grades);
    }

    /**
     * Display the grades for a specific exercise.
     */
    public function gradesByExercise(Exercise $exercise)
    {
        $grades = $exercise->grades()
            ->with(['student'])
            ->get();

        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this exercise.'], 404);
        }

        return response()->json($grades);
    }

    /**
     * Display the grades for a specific student and exercise.
     */
    public function gradesByStudentAndExercise(Student $student, Exercise $exercise)
    {
        $grades = $student->grades()
            ->whereBelongsTo($exercise)
            ->with(['student', 'exercise'])
            ->get();

        // Verifica si hay notas para el estudiante y ejercicio específicos
        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this student and exercise.'], 404);
        }

        return response()->json($grades);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'exercise_id' => 'sometimes|required|exists:exercises,id',
            'score' => 'sometimes|required|integer',
            'comment' => 'nullable|string|max:255',
        ]);

        $grade->update($request->all());

        return response()->json($grade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return response()->json(null, 204);
    }
}

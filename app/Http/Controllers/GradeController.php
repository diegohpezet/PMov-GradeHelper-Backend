<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Grade::all();
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
    public function show(string $id)
    {
        $course = Grade::find($id);

        if (!$course) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        return response()->json($course);
    }

    /**
     * Display the grades for a specific student.
     */
    public function gradesByStudent($studentId)
    {
        $grades = Grade::where('student_id', $studentId)
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
    public function gradesByExercise($exerciseId)
    {
        $grades = Grade::where('exercise_id', $exerciseId)
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
    public function gradesByStudentAndExercise($studentId, $exerciseId)
    {
        $grades = Grade::where('student_id', $studentId)
            ->where('exercise_id', $exerciseId)
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
    public function update(Request $request, string $id)
    {
        $course = Grade::find($id);

        if (!$course) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'exercise_id' => 'sometimes|required|exists:exercises,id',
            'score' => 'sometimes|required|integer',
            'comment' => 'nullable|string|max:255',
        ]);

        $course->update($request->all());

        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Grade::find($id);

        if (!$course) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $course->delete();

        return response()->json(null, 204);
    }
}

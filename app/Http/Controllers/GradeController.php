<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Grade;
use App\Models\Student;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Mail\ExerciseCorrection;
use App\Models\Gradeable;
use App\Models\NumericGrade;
use App\Models\PassFailGrade;
use App\Models\TEGrade;
use Illuminate\Http\Request;
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
        $validated = $request->validated();
    
        // Create grade model instance
        $models = [
            'PassFailGrade' => PassFailGrade::class,
            'NumericGrade' => NumericGrade::class,
            'TEGrade' => TEGrade::class,
        ];

        $gradeModel = new $models[$validated['gradeable_type']]([
            'value' => $validated['value'],
            'comment' => $validated['comment'],
        ]);
        $gradeModel->save();

        // Create gradeable
        $gradeable = Gradeable::create([
            'assessment_id' => $validated['assessment_id'],
            'student_id' => $validated['student_id'],
            'gradable_type' => $models[$validated['gradeable_type']],
            'gradable_id' => $gradeModel->id,
        ]);
    
        // Send email to student
        if ($studentEmail = $gradeable->student?->user?->email) {
            Mail::to($studentEmail)->send(new ExerciseCorrection($gradeable));
        }
    
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
    public function edit(Gradeable $grade)
    {
        return Inertia::render('Grades/Edit', [
            'grade' => $grade->load('gradable'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Gradeable $grade)
    {
        $grade->gradable->update($request->validated());

        return redirect()->back()->with('success', 'Grade updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gradeable $grade)
    {
        $grade->delete();

        return redirect()->back()->with('success', 'Gradeable deleted successfully');
    }
}

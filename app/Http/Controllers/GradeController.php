<?php

namespace App\Http\Controllers;

use App\Enums\GradeableType;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Mail\ExerciseCorrection;
use App\Models\Gradeable;
use App\Models\NumericGrade;
use App\Models\PassFailGrade;
use App\Models\TEGrade;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class GradeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $validated = $request->validated();
        
        // Check if gradeable type is valid
        $gradeableType = GradeableType::tryFrom($validated['gradeable_type']);
        
        if (!$gradeableType) {
            return redirect()->back()->withErrors(['gradeable_type' => 'Invalid grade type']);
        }
    
        // Create grade model instance
        $gradeModel = new ($gradeableType->model())([
            'value' => $validated['value'],
            'comment' => $validated['comment'],
        ]);
        $gradeModel->save();

        // Create gradeable
        $gradeable = Gradeable::create([
            'assessment_id' => $validated['assessment_id'],
            'student_id' => $validated['student_id'],
            'gradable_type' => $gradeableType->model(),
            'gradable_id' => $gradeModel->id,
        ]);
    
        // Send email to student
        if ($studentEmail = $gradeable->student?->user?->email) {
            Mail::to($studentEmail)->send(new ExerciseCorrection($gradeable));
        }
    
        return redirect()->back()->with('success', 'Grade created successfully');
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

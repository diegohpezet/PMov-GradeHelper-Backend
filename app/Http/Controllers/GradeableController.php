<?php

namespace App\Http\Controllers;

use App\Enums\GradeableType;
use App\Http\Requests\StoreGradeableRequest;
use App\Http\Requests\UpdateGradeableRequest;
use App\Mail\ExerciseCorrection;
use App\Models\Gradeable;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class GradeableController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeableRequest $request)
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
    
        return redirect()
            ->back()
            ->with('success', __('grades.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gradeable $gradeable)
    {
        return Inertia::render('Gradeables/Edit', [
            'gradeable' => $gradeable->load('gradable'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeableRequest $request, Gradeable $gradeable)
    {
        $gradeable->gradable->update($request->validated());

        return redirect()
            ->route('grades.index')
            ->with('success', __('grades.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gradeable $gradeable)
    {
        $gradeable->delete();

        return redirect()
            ->back()
            ->with('success', __('grades.deleted'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\GradeableType;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Mail\ExerciseCorrection;
use App\Models\Grade;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class GradesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $validated = $request->validated();

        // Check if gradeable type is valid
        $gradeableType = GradeableType::tryFrom($validated['gradeable_type']);

        if (! $gradeableType) {
            return redirect()->back()->withErrors(['gradeable_type' => 'Invalid grade type']);
        }

        $gradeableModel = new ($gradeableType->model())([
            'value' => $validated['value'],
            'comment' => $validated['comment'],
        ]);
        $gradeableModel->save();

        // Create gradeable
        $gradeable = Grade::create([
            'assessment_id' => $validated['assessment_id'],
            'student_id' => $validated['student_id'],
            'gradeable_type' => $gradeableType->model(),
            'gradeable_id' => $gradeableModel->id,
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
    public function edit(Grade $grade)
    {
        return Inertia::render('Gradeables/Edit', [
            'grade' => $grade,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->gradeable->update($request->validated());

        return redirect()
            ->back()
            ->with('success', __('grades.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()
            ->back()
            ->with('success', __('grades.deleted'));
    }
}

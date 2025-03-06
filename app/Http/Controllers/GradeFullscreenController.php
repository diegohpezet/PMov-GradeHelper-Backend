<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Course;
use App\Models\Grade;
use App\Enums\GradeableType;
use App\Http\Requests\BatchGradeRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeFullscreenController extends Controller
{
    public function show(Course $course, Request $request)
    {
        $course->load([
            'exercises',
            'students.grades',
        ]);
        return Inertia::render('GradeFullscreen/GradeFullscreenPage', [
            'course' => $course,
        ]);
    }

    public function batchGrade(Course $course, BatchGradeRequest $request)
    {
        // TODO: validate we're creating permitted grades
        // - user has permission
        // - user is in course
        // - every student and exercise are in course

        $gradesRequest = collect($request->grades);

        $assessmentIdByExerciseId = $course
            ->assessments()
            ->get(['id', 'exercise_id'])
            ->mapWithKeys(function (Assessment $assessment) {
                return [$assessment['exercise_id'] => $assessment['id']];
            });

        $gradesRequest->each(function ($gradeRequest) use ($assessmentIdByExerciseId) {
            $gradeableTypeModel = GradeableType::from($gradeRequest['grade_type'])->model();

            // creates a new gradeable
            $gradeableInstance = ($gradeableTypeModel)::create([
                'value' => $gradeRequest['grade_value'],
                'comment' => $gradeRequest['comment'],
            ]);

            Grade::create([
                'assessment_id' => $assessmentIdByExerciseId[$gradeRequest['exercise']],
                'student_id' => $gradeRequest['student'], 
                'gradeable_id' => $gradeableInstance->id,
                'gradeable_type'=> $gradeableTypeModel,
            ]);

            // TODO: mass create all grades at once
        });

        return redirect()
            ->back()
            ->with('success', __('grades.batchUpdated'));
    }
}

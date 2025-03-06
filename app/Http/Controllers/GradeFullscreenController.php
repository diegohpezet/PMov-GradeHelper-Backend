<?php

namespace App\Http\Controllers;

use App\Enums\GradeableType;
use App\Http\Requests\BatchGradeRequest;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Grade;
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

        // get course assessments, map from exercise id to assessment id
        $assessmentIdByExerciseId = $course
            ->assessments()
            ->get(['id', 'exercise_id'])
            ->mapWithKeys(function (Assessment $assessment) {
                return [$assessment['exercise_id'] => $assessment['id']];
            });

        collect($request->grades)
            ->whereNotNull('grade_type')
            ->each(function ($requestGrade) use ($assessmentIdByExerciseId) {
                $gradeableTypeModel = GradeableType::from($requestGrade['grade_type'])->model();

                // creates a new gradeable
                $gradeableInstance = ($gradeableTypeModel)::create([
                    'value' => $requestGrade['grade_value'],
                    'comment' => $requestGrade['comment'],
                ]);

                // TODO: mass create all grades at once
                Grade::create([
                    'assessment_id' => $assessmentIdByExerciseId[$requestGrade['exercise']],
                    'student_id' => $requestGrade['student'],
                    'gradeable_id' => $gradeableInstance->id,
                    'gradeable_type' => $gradeableTypeModel,
                ]);
            });

        return redirect()
            ->route('courses.show', $course)
            ->with('success', __('grades.batchUpdated'));
    }
}

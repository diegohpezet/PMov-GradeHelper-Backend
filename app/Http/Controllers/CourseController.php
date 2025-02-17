<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user()->load('student');

        $courses = [];
        if ($user->isAdmin()) {
            $courses = Course::all();
        }

        if ($user->student && $user->student->course_id) {
            $courses = [Course::where('id', $user->student->course_id)->first()];
        }

        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    /**
     * Display a listing of students for a specific course.
     */
    public function courseStudents(Course $course)
    {
        return response()->json($course->students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());

        return redirect()
            ->back()
            ->with('success', __('courses.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load([
            'students.course',
            'assessments.exercise',
            'students.gradeables.gradable',
            'attendances'
        ]);

        return inertia('Courses/Show', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('Courses/Edit', [
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return redirect()
            ->route('courses.index')
            ->with('success', __('courses.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->back()
            ->with('success', __('courses.deleted'));
    }
}

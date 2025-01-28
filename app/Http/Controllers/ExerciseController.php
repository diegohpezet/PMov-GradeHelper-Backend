<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Services\NotificationService;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    use Notify;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = Exercise::with('courses')->get();

        return Inertia::render('Exercises/Index', [
            'exercises' => $exercises
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        $exercise = Exercise::create($request->validated());
        
        $this->sendAdminNotification([
            'message' => 'A new exercise has been created: ' . $exercise->title,
            'action_by' => $request->user()->name
        ]);

        return redirect()->back()->with('success', 'Exercise created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        return Inertia::render('Exercises/Show', [
            'exercise' => $exercise
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        return Inertia::render('Exercises/Edit', [
            'exercise' => $exercise->load('courses')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update([
            'title' => $request->input('title'),
            'path' => $request->input('path'),
        ]);

        $coursesData = [];
        foreach ($request->input('courses', []) as $course) {
            $coursesData[$course['course_id']] = ['due_at' => $course['due_at']];
        }

        $exercise->courses()->sync($coursesData);

        $this->sendAdminNotification([
            'message' => 'An exercise has been updated: ' . $exercise->title,
            'action_by' => $request->user()->name
        ]);

        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise, Request $request)
    {
        $exercise->delete();

        $this->sendAdminNotification([
            'message' => 'An exercise has been removed: ' . $exercise->title,
            'action_by' => $request->user()->name
        ]);

        return redirect()->back()->with('success', 'Exercise deleted successfully');
    }
}

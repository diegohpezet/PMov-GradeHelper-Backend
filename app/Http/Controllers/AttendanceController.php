<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        $attendance = Attendance::create($request->validated());

        return response()->json($attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRequest $request)
    {
        Attendance::where([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'date' => $request->date,
        ])->delete();

        return response()->json(null, 204);
    }
}

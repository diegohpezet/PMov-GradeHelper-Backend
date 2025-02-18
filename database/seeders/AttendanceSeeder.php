<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();

        $students->each(function (Student $student) {
            for ($i = 0; $i < 3; $i++) {
                // Generate a unique date for each attendance record
                $date = Carbon::today()
                    ->addDays(fake()->numberBetween(-100, 100))
                    ->toDateString();

                // Check if the record already exists
                $exists = Attendance::where('student_id', $student->id)
                    ->where('course_id', $student->course_id)
                    ->where('date', $date)
                    ->exists();

                // Create the record only if it doesn't already exist
                if (!$exists) {
                    Attendance::factory()
                        ->for($student)
                        ->for($student->course)
                        ->create(['date' => $date]);
                }
            }
        });
    }
}

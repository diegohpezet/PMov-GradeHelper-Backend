<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();

        $students->each(function (Student $student) {
            for ($i = 0; $i < 3; $i++) {
                // Generate a unique date for each attendance record
                do {
                    $date = now()
                        ->addDays(fake()->numberBetween(-10, 10))
                        ->toDateString();

                    $exists = Attendance::where('student_id', $student->id)
                        ->where('course_id', $student->course_id)
                        ->where('date', $date)
                        ->exists();
                } while ($exists);

                // Create the attendance record
                Attendance::factory()
                    ->for($student)
                    ->for($student->course)
                    ->create(['date' => $date]);
            }
        });
    }
}

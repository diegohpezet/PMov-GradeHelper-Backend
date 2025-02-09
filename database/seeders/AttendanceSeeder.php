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
      Attendance::factory(3)
        ->for($student)
        ->for($student->course)
        ->create();
    });
  }
}

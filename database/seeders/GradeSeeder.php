<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
  public function run()
  {
    $students = Student::all();

    $students->each(function (Student $student) {
      Grade::factory(3)
        ->for($student)
        ->recycle($student->course->exercises)
        ->create();
    });
  }
}

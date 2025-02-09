<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::factory(10)->recycle(Course::all())->create();
    }
}

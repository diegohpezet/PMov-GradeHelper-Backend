<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Grade;
use App\Models\Student;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $courses = Course::factory()
            ->count(3)
            ->create();

        $students = Student::factory(10)
            ->recycle($courses)
            ->create();

        $exercises = Exercise::factory(5)
            ->hasAttached($courses)
            ->create();

        $students->each(function (Student $student) {
            Grade::factory(3)
                ->for($student)
                ->recycle($student->course->exercises)
                ->create();
        });

        $this->call(RoleSeeder::class);
    }
}

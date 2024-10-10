<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $courses = $courses = Course::factory()
            ->count(3)
            ->hasStudents(10)
            ->create();

        Exercise::factory(5)->hasAttached($courses)->create();
    }
}

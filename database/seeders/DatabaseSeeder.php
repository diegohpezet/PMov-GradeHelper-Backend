<?php

namespace Database\Seeders;

use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            StudentSeeder::class,
            ExerciseSeeder::class,
            GradeableSeeder::class,
            AttendanceSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}

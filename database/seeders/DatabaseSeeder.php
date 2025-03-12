<?php

namespace Database\Seeders;

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
            GradeSeeder::class,
            AttendanceSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}

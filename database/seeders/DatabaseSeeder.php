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

        $exercises = Exercise::factory()
            ->count(3)
            ->create();

        $exercises->each(function (Exercise $exercise) use ($courses) {
            // select 2 courses to attach each exercise
            $courses->random(2)->each(function (Course $course) use ($exercise) {
                $exercise->courses()
                    ->attach($course, [
                        'due_at' => $this::getRandomFutureDate(),
                    ]);
            });
        });

        $students->each(function (Student $student) {
            Grade::factory(3)
                ->for($student)
                ->recycle($student->course->exercises)
                ->create();
        });

        $this->call(RoleSeeder::class);

        // creates a new user and relates it to a student
        $studentUser = User::factory()->create([
            'email' => 'student@example.com',
        ]);
        $studentUser->student()->save($students->random());

        // creates a new admin user and assign role
        $adminUser = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $adminUser->assignRole('admin');
    }

    private static function getRandomFutureDate($min = 7, $max = 60): \Illuminate\Support\Carbon
    {
        $randomDays = fake()->numberBetween($min, $max);
        $randomDueDate = now()->add($randomDays, 'day');
        logger([$randomDays, $randomDueDate]);
        return $randomDueDate;
    }
}

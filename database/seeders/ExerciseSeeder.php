<?php

namespace Database\Seeders;

use App\Enums\GradeableType;
use App\Models\Course;
use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        $allCourses = Course::all();
        $exercises = Exercise::factory()->count(3)->create();

        $exercises->each(function (Exercise $exercise) use ($allCourses) {
            // select 2 courses to attach each exercise onto
            $allCourses->random(2)->each(function (Course $course) use ($exercise) {
                $exercise->courses()
                    ->attach($course, [
                        'grade_type' => GradeableType::all()->random(),
                        'due_at' => $this::getRandomFutureDate(),
                    ]);
            });
        });
    }

    private static function getRandomFutureDate($min = 7, $max = 60): \Illuminate\Support\Carbon
    {
        $randomDays = fake()->numberBetween($min, $max);
        $randomDueDate = now()->add($randomDays, 'day');
        logger([$randomDays, $randomDueDate]);

        return $randomDueDate;
    }
}

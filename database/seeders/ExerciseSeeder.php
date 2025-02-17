<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
  public function run()
  {
    $courses = Course::all();
    $exercises = Exercise::factory()->count(3)->create();

    $exercises->each(function (Exercise $exercise) use ($courses) {
      // select 2 courses to attach each exercise
      $courses->random(2)->each(function (Course $course) use ($exercise) {
        $exercise->courses()
          ->attach($course, [
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

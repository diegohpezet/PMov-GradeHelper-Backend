<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'exercise_id' => Exercise::factory(),
            'score' => fake()->numberBetween(1, 10),
            'comment' => fake()->text(),
        ];
    }
}

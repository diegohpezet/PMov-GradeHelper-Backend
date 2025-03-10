<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    private static int $counter = 1;

    public function definition(): array
    {
        return [
            'title' => 'Exercise '.self::$counter,
            'path' => 'tp-'.self::$counter++,
        ];
    }
}

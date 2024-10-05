<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    private static int $counter = 1;

    public function definition(): array
    {
        return [
            'title' => 'Exercise ' . self::$counter,
            'path' => 'tp-' . self::$counter++,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    private static int $division = 2;
    private static array $suffixes = ['d', 'r', 't'];

    public function definition(): array
    {
        $suffix = self::$suffixes[self::$division - 2];
        $name = '7mo' . self::$division++ . $suffix . 'a';

        return [
            'name' => $name,
            'school_year' => "2024"
        ];
    }
}

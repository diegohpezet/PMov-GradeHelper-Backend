<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    private static array $divisions = ['1ro', '2do', '3ro', '4to', '5to', '6to', '7mo'];

    private static array $sections = ['1ra', '2da', '3ra', '4ta'];

    private static array $orientations = ['Programación', 'Informática'];

    public function definition(): array
    {
        return [
            'name' => self::generateCourseName(),
            'description' => fake()->sentence(),
            'school_year' => now()->year,
        ];
    }

    private static function generateCourseName()
    {
        $division = fake()->randomElement(self::$divisions);
        $section = fake()->randomElement(self::$sections);
        $orientation = fake()->randomElement(self::$orientations);

        return "$division $section ($orientation)";
    }
}

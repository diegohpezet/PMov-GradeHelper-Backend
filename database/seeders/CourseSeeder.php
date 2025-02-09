<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
  public function run()
  {
    Course::factory()->count(3)->create();
  }
}

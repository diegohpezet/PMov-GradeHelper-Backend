<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Grade;
use App\Models\NumericGrade;
use App\Models\PassFailGrade;
use App\Models\Student;
use App\Models\TEGrade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $students = Student::all();
        $assessments = Assessment::all();

        foreach ($students as $student) {
            foreach ($assessments as $assessment) {
                // Select a random grade type & create it
                $gradeType = collect([
                    NumericGrade::class,
                    PassFailGrade::class,
                    TEGrade::class,
                ])->random();

                $concreteGrade = $gradeType::factory()->create();

                $student->grades()->create([
                    'assessment_id' => $assessment->id,
                    'gradeable_type' => $gradeType,
                    'gradeable_id' => $concreteGrade->id,
                ]);
            }
        }
    }
}

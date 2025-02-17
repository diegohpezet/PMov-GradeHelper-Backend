<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Gradeable;
use App\Models\NumericGrade;
use App\Models\PassFailGrade;
use App\Models\Student;
use App\Models\TEGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeableSeeder extends Seeder
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
                $gradeType = collect([NumericGrade::class, PassFailGrade::class, TEGrade::class])->random();
                $grade = $gradeType::factory()->create();

                // Associate the grade with the assessment
                Gradeable::create([
                    'assessment_id' => $assessment->id,
                    'student_id' => $student->id,
                    'gradable_id' => $grade->id,
                    'gradable_type' => $gradeType,
                ]);
            }
        }
    }
}

<?php

namespace App\Enums;

enum GradeableType: string
{
    case PassFailGrade = 'PassFailGrade';
    case NumericGrade = 'NumericGrade';
    case TEGrade = 'TEGrade';

    public function model(): string
    {
        return match ($this) {
            self::PassFailGrade => \App\Models\PassFailGrade::class,
            self::NumericGrade => \App\Models\NumericGrade::class,
            self::TEGrade => \App\Models\TEGrade::class,
        };
    }
}
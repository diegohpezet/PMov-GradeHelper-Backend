<?php

namespace App\Enums\Enums;

enum GradeResult: string
{
    case PASSED = 'passed';
    case FAILED = 'failed';

    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}

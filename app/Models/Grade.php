<?php

namespace App\Models;

use App\Enums\Enums\GradeResult;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'student_id',
        'exercise_id',
        'result',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'result' => GradeResult::class,
        ];
    }

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}

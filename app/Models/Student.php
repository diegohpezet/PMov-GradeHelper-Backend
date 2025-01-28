<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'first_name',
        'last_name',
        'githubUsername',
        'course_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function transformWithGrades($exercises)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'githubUsername' => $this->githubUsername,
            'grades' => $exercises->map(fn($exercise) => $this->transformExerciseGrades($exercise))
        ];
    }

    private function transformExerciseGrades($exercise)
    {
        return [
            'exercise_id' => $exercise->id,
            'grades' => $this->grades
                ->where('exercise_id', $exercise->id)
                ->map->toArray()
                ->values(),
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('githubUsername', $value)
            ->firstOrFail();
    }
}

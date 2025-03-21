<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'school_year',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'assessments')
            ->withPivot(['id', 'due_at'])
            ->withTimestamps()
            ->using(Assessment::class)
            ->as('assessment')
            ->orderBy('title');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}

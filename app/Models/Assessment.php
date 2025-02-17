<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Assessment extends Pivot
{
    use HasUuids;

    protected $table = 'assessments';

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
        ];
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function gradeables(): HasMany
    {
        return $this->hasMany(Gradeable::class);
    }
}

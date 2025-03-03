<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasUuids;
    
    protected $fillable = ['assessment_id', 'student_id', 'gradeable_id', 'gradeable_type'];

    protected $with = ['gradeable'];

    public function gradeable()
    {
        return $this->morphTo();
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Gradeable extends Model
{
    use HasUuids;
    
    protected $fillable = ['assessment_id', 'student_id', 'gradable_id', 'gradable_type'];

    public function gradable()
    {
        return $this->morphTo('gradable', 'gradable_type', 'gradable_id');
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

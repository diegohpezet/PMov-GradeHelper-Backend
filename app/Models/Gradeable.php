<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gradeable extends Model
{
    protected $fillable = ['assessment_id', 'student_id', 'gradable_id', 'gradable_type'];

    public function gradeable()
    {
        return $this->morphTo();
    }
}

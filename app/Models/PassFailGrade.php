<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassFailGrade extends Model
{
    protected $fillable = ['value', 'comment'];

    public function gradeable()
    {
        return $this->morphOne(Gradeable::class, 'gradable');
    }
}


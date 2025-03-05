<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumericGrade extends Model
{
    use HasFactory;

    protected $table = 'numeric_grades';

    protected $fillable = ['value', 'comment'];

    public function grade()
    {
        return $this->morphOne(Grade::class, 'gradeable');
    }
}


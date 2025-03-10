<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassFailGrade extends Model
{
    use HasFactory;

    protected $table = 'pass_fail_grades';

    protected $fillable = ['value', 'comment'];

    public function gradeable()
    {
        return $this->morphOne(Grade::class, 'gradeable');
    }
}

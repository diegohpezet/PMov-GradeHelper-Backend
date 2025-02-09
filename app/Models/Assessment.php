<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Assessment extends Pivot
{
    use HasUuids;

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
        ];
    }
}


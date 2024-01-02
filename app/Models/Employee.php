<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function dept(): BelongsTo
    {
        return $this->belongsTo(Dept::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}

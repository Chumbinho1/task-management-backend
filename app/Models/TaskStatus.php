<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    protected $fillable = [
        'description',
        'slug',
        'order',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}

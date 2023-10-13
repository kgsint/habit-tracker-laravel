<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    // polymophic
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function habit(): BelongsToMany
    {
        return $this->belongsToMany(Habit::class);
    }
}

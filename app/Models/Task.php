<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_complete' => 'boolean',
    ];

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    // polymophic
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function trackActivity(string $description): void
    {
        $this->activities()->create([
            'user_id' => auth()->id(),
            'habit_id' => $this->habit->id,
            'description' => $description,
        ]);
    }

    public function complete(): void
    {
        $this->update([
            'is_complete' => true,
        ]);

        $this->trackActivity('completed_task');
    }

    public function inComplete(): void
    {
        $this->update([
            'is_complete' => false,
        ]);

        $this->trackActivity('incompleted_task');
    }
}

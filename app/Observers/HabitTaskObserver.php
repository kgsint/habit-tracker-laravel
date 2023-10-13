<?php

namespace App\Observers;

use App\Models\Task;

class HabitTaskObserver
{
    public function created(Task $task)
    {
        $task->activities()->create([
            'habit_id' => $task->habit->id,
            'user_id' => auth()->id(),
            'description' => 'created_task',
        ]);
    }

    public function deleting(Task $task)
    {
        $task->activities()->create([
            'habit_id' => $task->habit_id,
            'user_id' => auth()->id(),
            'description' => 'deleted_task',
        ]);
    }
}

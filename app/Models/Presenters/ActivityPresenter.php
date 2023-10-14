<?php

namespace App\Models\Presenters;

use App\Models\Activity;

class ActivityPresenter
{
    // constructor promoted
    public function __construct(private Activity $activity){}

    public function present()
    {
        $taskBody = $this->activity?->subject->body ?? 'a task';

        // json to php array
        if($this->activity->changes) {
            $changes = json_decode($this->activity->changes, true);

            $updatedHabitDesc = count($changes['after']) === 1 ?
            'You updated "' . key($changes['after']) . '" of the habit' :
            "You edited the habit";

        }


        return match($this->activity->description) {
            'created' => 'You created a habit',
            'updated' => $updatedHabitDesc,
            'created_task' => "You created  '{$taskBody}'",
            'completed_task' => "You completed '{$taskBody}'",
            'incompleted_task' => "You unchecked '{$taskBody}'",
            'deleted_task' => "You deleted {$taskBody}",
            default => 'unknown'
        };


    }
}

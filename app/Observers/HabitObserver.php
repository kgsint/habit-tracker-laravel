<?php

namespace App\Observers;

use App\Models\Habit;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class HabitObserver
{
    public function created(Habit $habit)
    {
        // track activity
        $habit->activities()->create([
            'description' => 'created',
            'user_id' => $habit->user->id,
        ]);
    }

    public function updated(Habit $habit)
    {
        $old = $habit->getOriginal();
        // remove unwanted paris (only want to compare title and description)
        $old = array_diff_key($old, array_flip(['id', 'user_id', 'created_at', 'updated_at']));

        /**
         * array_diff_key returns a two-dimensional array from from first array which keys are not present in other array(s)
         * array_diff returns a two-dimensional array from first array which values are not present in other array(s)
        */
         $habit->activities()->create([
            'description' => 'updated',
            'user_id' => $habit->user->id,
            'changes' => json_encode([
                'before' => array_diff($old, $habit->only('title', 'description')),
                'after' => array_diff($habit->only('title', 'description'), $old),
            ])
            ]);

    }
}

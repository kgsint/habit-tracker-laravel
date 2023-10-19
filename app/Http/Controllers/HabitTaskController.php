<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Task;
use Illuminate\Http\Request;

class HabitTaskController extends Controller
{

    public function store(Request $request, Habit $habit)
    {
        // authorize
        $this->authorize('manage', $habit);

        // validate
        $request->validate([
            'body' => 'required|string'
        ]);
        // add task
        $habit->tasks()->create(['body' => $request->body]);

        return redirect()->route('habits.show', $habit->id);
    }

    public function update(Request $request, Habit $habit, Task $task)
    {
         // authorize
         $this->authorize('manage', $habit);

        // if body has no text, delete task
        if(!$request->body || strlen($request->body) === 0) {
            $task->delete();

            return redirect()->route('habits.show', $habit->id);
        }

        // update and save activity only if the previous state and current state aren't the same
        if($request->body !== $task->body) {
            // update if there is body,
            $task->update([
                'body' => $request->body
            ]);

            // track activity
            $task->trackActivity('updated_task');

            return response()->json(['message' => 'task updated'], status:200);
        }

        // complete or incomplete task
        $this->completeOrIncomplete($request, $task);

        return response()->json(['message' => 'task updated'], status:200);

    }

    private function completeOrIncomplete(Request $request, Task $task)
    {
        // when the request has is_complete or the user is checked
        if($request->is_complete) {
            $task->complete();
        }elseif(! $request->is_complete && $task->is_complete === true) { // uncheck only if the request has no is_complete
            $task->inComplete();                                          // and the previous state of the task is true
        }
    }

}

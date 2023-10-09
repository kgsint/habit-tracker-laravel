<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Task;
use Illuminate\Http\Request;

class HabitTaskController extends Controller
{
    public function store(Request $request, Habit $habit)
    {
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
        // if body has no text, delete task
        if(!$request->body || strlen($request->body) === 0) {
            $task->delete();

            return redirect()->route('habits.show', $habit->id);
        }

        // update if there is body,
        $task->update([
            'body' => $request->body
        ]);


        // complete or incomplete task
        if($request->is_complete) {
            $task->update([
                'is_complete' => true,
            ]);
        }else {
            $task->update([
                'is_complete' => false,
            ]);
        }

        return redirect()->route('habits.show', $habit->id);

    }

}

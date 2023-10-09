<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitTaskController extends Controller
{
    public function store(Request $request, Habit $habit)
    {
        // validate
        $request->validate([
            'body' => 'required|string'
        ]);

        dd($habit->tasks()->create(['body' => $request->body]));

        // add task
        $habit->tasks()->create(['body' => $request->body]);

        return redirect()->route('habits.show', $habit->id);
    }
}

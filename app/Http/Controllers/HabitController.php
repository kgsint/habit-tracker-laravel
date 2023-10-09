<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        return view('habits.index', [
            'habits' => Habit::whereBelongsTo(auth()->user())->get(),
        ]);
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(StoreHabitRequest $request)
    {
        $habit = $request->user()
                        ->habits()
                        ->create($request->validated());

        return redirect(route('habits.show', $habit->id));
    }

    public function show(Habit $habit)
    {
        $completedTasks = $habit->tasks()->where('is_complete', true)->get();
        $incompletedTasks = $habit->tasks()->where('is_complete', false)->get();

        return view('habits.show', compact('habit', 'completedTasks', 'incompletedTasks'));
    }

    public function edit(Habit $habit)
    {
        return view('habits.edit', compact('habit'));
    }

    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        $habit->update($request->validated());

        return redirect(route('habits.show', $habit->id));
    }

    public function destroy(Habit $habit)
    {
        $title = $habit->title;

        $habit->delete();

        return redirect()->route('habits.index')->with('status', "{$title} has been deleted");
    }
}

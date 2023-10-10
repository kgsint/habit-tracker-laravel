<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HabitController extends Controller
{

    public function index()
    {
        $habits = Habit::whereBelongsTo(auth()->user())->get();

        // return $habits;
        return HabitResource::collection($habits);
    }

    public function store(StoreHabitRequest $request)
    {
        $habit = auth()->user()->habits()->create($request->validated());

        return response()->json([
            'habit' => new HabitResource($habit),
        ], 201);
    }

    // show
    public function show(string $id)
    {
        $habit = Habit::find($id);

        // if $habit doesn't exist or doesn't have access to the current user
        if(! $habit || Gate::denies('view', $habit)) {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }

        return new HabitResource($habit);
    }

    // update
    public function update(UpdateHabitRequest $request, string $id)
    {
        $habit = Habit::find($id);

        // if $habit doesn't exist or doesn't have access to the current user
        if(!$habit || Gate::denies('update', $habit)) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $habit->update($request->validated());

        $updatedHabit = Habit::find($id);

        return new HabitResource($updatedHabit);
    }

    // delete
    public function destroy(string $id)
    {
        $habit = Habit::find($id);

        if(!$habit || Gate::denies('update', $habit)) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $habit->delete();

        return response()->json([], 204);
    }
}

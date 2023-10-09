<?php

use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitTaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // habit
    Route::get('/', [HabitController::class, 'index'])->name('habits.index');
    Route::resource('/habits', HabitController::class)->except('index');

    // task
    Route::post('/habits/{habit}/tasks', [HabitTaskController::class, 'store'])
                                                                                ->name('tasks.store');
    Route::patch('/habits/{habit}/tasks/{task}', [HabitTaskController::class, 'update'])
                                                                                    ->name('tasks.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

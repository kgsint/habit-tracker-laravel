<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HabitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('habits', HabitController::class)->names([
            'index' => 'habits.api.index',
            'show' => 'habits.api.show',
            'store' => 'habits.api.store',
            'update' => 'habits.api.update',
            'destroy' => 'habits.api.destroy',
        ]);
    });
});


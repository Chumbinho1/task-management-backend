<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskModule\TaskController;
use App\Http\Controllers\TaskModule\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('signin', [AuthController::class, 'signin'])->name('signin');

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('signout', [AuthController::class, 'signout'])->name('signout');
    });
});

Route::middleware('auth:sanctum')->apiResource('tasks', TaskController::class);

Route::middleware('auth:sanctum')->apiResource('task-statuses', TaskStatusController::class)->only(['index']);

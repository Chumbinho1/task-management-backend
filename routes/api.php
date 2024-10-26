<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskModule\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('signin', [AuthController::class, 'signin'])->name('signin');
});

Route::middleware('auth:sanctum')->prefix('/tasks')->name('tasks.')->group(function () {
    Route::post('/', [TaskController::class, 'store'])->name('store');
});

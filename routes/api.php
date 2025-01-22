<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User Routers

Route::get('/users', [UserController::class, 'list']);    // List all users
Route::get('/users/{user}', [UserController::class, 'index']); // Show a user
Route::post('/users', [UserController::class, 'create']);   // Create a new user
Route::put('/users/{user}', [UserController::class, 'update']); // Update a user (full update)
Route::patch('/users/{user}', [UserController::class, 'update']); // Update a user (partial update)
Route::delete('/users/{user}', [UserController::class, 'delete']); // Delete a user




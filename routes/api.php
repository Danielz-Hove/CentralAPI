<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

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


// GET /api/customers (Index - List all customers)
Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth:sanctum');

// POST /api/customers (Store - Create a new customer)
Route::post('/customers', [CustomerController::class, 'store'])->middleware('auth:sanctum');

// GET /api/customers/{customer} (Show - Get a specific customer by ID)
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->middleware('auth:sanctum');

// PUT/PATCH /api/customers/{customer} (Update - Update an existing customer)
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->middleware('auth:sanctum');  // PUT (replace)
Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->middleware('auth:sanctum'); // PATCH (partial update - often more common)

// DELETE /api/customers/{customer} (Destroy - Delete a customer)
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

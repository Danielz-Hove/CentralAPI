<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str; // For generating a random token

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user after validation
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Generate API token
        $token = Str::random(60); // Generate a random string of 60 characters
        $user->api_token = $token;   // Assign the token to the user model
        $user->save();                  // Save the user to the database

        // Return JSON response with the user details and token
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token // Include token in the response
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function index(string $id)
    {
        return $this->findUserById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Retrieve the user by ID
        $user = User::find($id);

        // If the user is not found, return a 404 response
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Hash the password if it is provided
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Update the user with the validated data
        $user->update(array_filter($validated));

        // Return a success response with the updated user
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        // Attempt to find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return a success response
        return response()->json(['message' => 'User removed successfully'], 200);
    }

    /**
     * Helper function to find a user by ID.
     */
    private function findUserById(string $id)
    {
        $user = User::find($id);
        return $user ? response()->json($user, 200) : response()->json(['message' => 'User not found'], 404);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT; // Ensure the JWT class is imported
use Firebase\JWT\Key; // Import Key class
use Exception;

class EnsureTokenExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Access token is required.',
            ], 401);
        }

        try {
            // JWT Validation using firebase/php-jwt

            // Retrieve the JWT secret from the .env file.  Make sure it's set!
            $key = env('JWT_SECRET');

            if (!$key) {
                throw new Exception("JWT_SECRET is not set in your .env file.");
            }

            $decoded = JWT::decode($token, new Key($key, 'HS256')); // Decode with key and algorithm

            // If the token is valid, you can optionally attach the decoded data to the request.
            // This allows subsequent controllers/middleware to access the token's payload (e.g., user ID).
            $request->attributes->add(['jwt_payload' => $decoded]);

        } catch (Exception $e) { // Catch any JWT-related exceptions.
            return response()->json([
                'message' => 'Invalid access token.',
                'error' => $e->getMessage(),  // Useful for debugging (remove in production)
            ], 401);
        }

        return $next($request);
    }
}
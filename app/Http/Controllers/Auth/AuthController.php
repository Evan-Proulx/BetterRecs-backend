<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:8'
        ]);

        //try to create a new user
        try {
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password'])
            ]);

            // Generate the token for the user
            $token = $this->createToken($user);

            return response()->json([
                'message' => 'User Created',
                'data' => $token
            ], 201);

        } catch (QueryException $e) {
            // Check if the error is related to a unique constraint (email)
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'The email has already been taken',
                ], 422);
            }

            // Handle other potential errors
            return response()->json([
                'message' => 'An error occurred while creating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function auth(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        // Generate a unique API token for the user for authentication
        $token = $this->createToken($user);

        return response()->json([
            'message' => 'User Authenticated',
            'data' => $token
        ], 201);
    }

    private function createToken(User $user) {
        $token = $user->createToken('apitoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}

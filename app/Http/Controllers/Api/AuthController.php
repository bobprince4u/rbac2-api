<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'success' => true,
            'code' => 201,
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'data' => [],
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'message' => 'Login successful',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'Logout successful',
        ], 200);
    }
}


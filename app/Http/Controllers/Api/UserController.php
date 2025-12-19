<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => ['users' => $users],
            'message' => 'Users retrieved successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
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

        return response()->json([
            'success' => true,
            'code' => 201,
            'data' => ['user' => $user],
            'message' => 'User created successfully',
        ], 201);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'data' => [],
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => ['user' => $user],
            'message' => 'User retrieved successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'data' => [],
                'message' => 'User not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $data = $request->only(['name', 'email']);
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => ['user' => $user],
            'message' => 'User updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'data' => [],
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'User deleted successfully',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function assignRoleToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => ['user' => $user->load('roles')],
            'message' => 'Role assigned to user successfully',
        ], 200);
    }

    public function assignPermissionToRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);

        $role->assignPermission($permission);

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => ['role' => $role->load('permissions')],
            'message' => 'Permission assigned to role successfully',
        ], 200);
    }
}


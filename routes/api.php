<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ExternalController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Role management
    Route::post('/roles/assign-user', [RoleController::class, 'assignRoleToUser']);
    Route::post('/roles/assign-permission', [RoleController::class, 'assignPermissionToRole']);
    
    // User CRUD with permissions
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:view-users');
    
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:create-user');
    
    Route::get('/users/{id}', [UserController::class, 'show'])
        ->middleware('permission:view-users');
    
    Route::put('/users/{id}', [UserController::class, 'update'])
        ->middleware('permission:update-user');
    
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->middleware('permission:delete-user');
    
    // External API
    Route::get('/external/users', [ExternalController::class, 'getUsers']);
});

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'data' => [],
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Check if the user has the required permission
        if (!$request->user()->hasPermission($permission)) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'data' => [],
                'message' => 'Unauthorized. You do not have the required permission.',
            ], 403);
        }

        return $next($request);
    }
}

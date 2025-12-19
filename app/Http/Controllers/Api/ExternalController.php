<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ExternalController extends Controller
{
    public function getUsers()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/users');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'data' => ['users' => $response->json()],
                    'message' => 'External users retrieved successfully',
                ], 200);
            }

            return response()->json([
                'success' => false,
                'code' => $response->status(),
                'data' => [],
                'message' => 'Failed to fetch external users',
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'data' => [],
                'message' => 'Error fetching external users: ' . $e->getMessage(),
            ], 500);
        }
    }
}

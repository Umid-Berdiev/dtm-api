<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AccessControlMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $accessKey = Route::currentRouteName();

        if ($accessKey && !is_null($user = auth()->user())) {
            $permissions = $user['role']['permissions'] ?? null;

            $access = collect($permissions)->where('name', $accessKey)->first();

            if (is_null($access)) {
                return response()->json([
                    'message' => __('info.access_or_action_denied'),
                ], JsonResponse::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}

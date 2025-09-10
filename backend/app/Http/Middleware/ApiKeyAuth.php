<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        $apiSecret = $request->header('X-API-SECRET');

        if (!$apiKey || !$apiSecret) {
            return response()->json(['message' => 'API key and secret required'], 401);
        }

        $tenant = Tenant::where('api_key', $apiKey)
            ->where('api_secret', $apiSecret)
            ->first();

        if (!$tenant) {
            return response()->json(['message' => 'Invalid API credentials'], 403);
        }

        // Store tenant in request for later use
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}

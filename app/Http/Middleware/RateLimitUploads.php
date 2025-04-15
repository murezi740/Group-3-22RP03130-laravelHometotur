<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply rate limiting to requests with files
        if ($request->hasFile('files')) {
            $key = 'uploads.' . $request->user()->id;

            // Allow 20 uploads per hour
            if (RateLimiter::tooManyAttempts($key, 20)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'error' => 'Upload limit reached. Please try again in ' . $seconds . ' seconds.'
                ], 429);
            }

            RateLimiter::hit($key, 3600); // Key expires in 1 hour
        }

        return $next($request);
    }
}

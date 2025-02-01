<?php

namespace App\Http\Middleware;
 
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
 
class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = auth()->user()) {
            $user->timestamps = false; // Prevents updating created_at & updated_at
            $user->last_activity = now()->getTimestamp();

            // Check if the user is visiting 'caas.announcement' route
            if (Route::currentRouteName() === 'caas.announcement') {
                $user->last_seen_announcement = now()->getTimestamp();
            }
            
            $user->saveQuietly();
        }
 
        return $next($request);
    }
}
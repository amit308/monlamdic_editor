<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track activity for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update last activity timestamp
            $user->last_activity_at = now();
            
            // Update last login time and IP if this is a fresh login
            if (!$user->last_login_at || $user->last_login_at->diffInMinutes(now()) > 5) {
                $user->last_login_at = now();
                $user->last_login_ip = $request->ip();
                
                // Log the login event
                Log::info('User logged in', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
            
            // Save the updates
            $user->save();
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
        /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $moduleName): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $module = $user->modules()
            ->where('name', $moduleName)
            ->wherePivot('is_active', true)
            ->first();

        if (! $module) {
            return response()->json(['error' => "Module '$moduleName' non actif"], 403);
        }

        return $next($request);
    }
}


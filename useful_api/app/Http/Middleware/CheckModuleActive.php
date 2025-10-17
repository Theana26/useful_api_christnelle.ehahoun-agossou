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

    public function handle(Request $request, Closure $next, $moduleName)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['error' => 'User unauthenticated'], 401);
        }
        //vérifier si le module est actif
        $module_isActive = $user->modules()
            ->where('name', $moduleName)
            ->wherePivot('is_active', true)
            ->first();

        if (! $module_isActive) {
            return response()->json(['error' => "Module inactive. Please activate this modulee to use it."], 403);
        }

        return $next($request);
    }
}


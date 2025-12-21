<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $role): Response
    {
          $roleMap = [
                'admin' => 1,
                'user' => 0,
            ];
        if ((int)auth()->user()->role !== ($roleMap[$role] ?? null)) {
        return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}

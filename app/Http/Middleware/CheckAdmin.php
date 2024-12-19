<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = request()->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
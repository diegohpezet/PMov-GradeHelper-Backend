<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = request()->user();

        if (! $user || ! $user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    const UNAUTHORIZED_STATUS = 401;
    const UNAUTHORIZED_MESSAGE = 'Access denied.';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->admin)
        {
            return $next($request);
        }
        return response()->json(['error' => self::UNAUTHORIZED_MESSAGE], self::UNAUTHORIZED_STATUS);
    }
}

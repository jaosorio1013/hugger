<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TruncatingDataMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Cache::get('truncating-data')) {
            abort(503);
        }

        return $next($request);
    }
}

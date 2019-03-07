<?php

namespace App\Http\Middleware\VinaEnter;

use Closure;

class VneAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        
        return $next($request);
    }
}

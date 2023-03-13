<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  cd$request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Origin: Content-type, X-Auth-Token, Authorization, Origin');
        //header('Access-Control-Allow-Origin: http://localhost:4200');
        // header('Access-Control-Allow-Headers: Content-type, X-Auth-Token, Authorization, Origin, Accept, Access-Control-Request-Method  ');
        // header('Access-Control-Request-Headers: * ');
         header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        return $next($request);
    }
}



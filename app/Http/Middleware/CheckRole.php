<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //Middleware za provjeru role korisnika te sprjecavanje pristupa ruti
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!Auth::check() || !in_array(Auth::user()->role, $roles))
        {
            abort(403,"Unauthorized action.");
        }

        return $next($request);
    }
}

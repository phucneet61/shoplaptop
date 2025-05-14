<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Support\Facades\Route;
use Closure;
use Illuminate\Http\Request;

class AccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->hasAnyRoles(['admin', 'author'])) {
            return $next($request);
        }
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }
}

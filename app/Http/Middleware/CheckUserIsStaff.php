<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if(!$request->user()){
        return redirect('/login');
       }

       if(!$request->user() || !$request->user()->isStaff()){
        abort(403, 'Access denied. You need to be a staff member.');
       }


        return $next($request);
    }
}

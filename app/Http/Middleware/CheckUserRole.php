<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Auth::check())
        {
            $prefix = $request->route()->getPrefix();
            if($prefix == '/admin')
            {
                if(Auth::user()->isUser())
                {
                    return redirect()->route('user.dashboard');
                }
            }else if($prefix == '/user')
            {
                if(Auth::user()->isAdmin())
                {
                    // return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}

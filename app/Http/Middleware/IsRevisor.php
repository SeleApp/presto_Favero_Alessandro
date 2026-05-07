<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsRevisor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! (Auth::check() && Auth::user()->is_revisor)) {
            return redirect()->route('homepage')->with('error', 'Accesso negato. Solo i revisori possono accedere a quest\'area.');
        }

        return $next($request);
    }
}

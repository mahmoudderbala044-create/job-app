<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class rolemidddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if ($request->user() && in_array($request->user()->role, $roles)) {
            return $next($request);
        }
        
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors(['email' => 'هذا الحساب غير مصرح له بالدخول. يرجى تسجيل الدخول بحساب باحث عن عمل.']); 
    }
}
       

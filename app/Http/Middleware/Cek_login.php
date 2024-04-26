<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
//        check if user is not logged in
        if (!Auth::check()) {
            return redirect('login');
        }

//        check if user has the right role
        $user = Auth::user();
        if ($user->level_id == $roles) {
            return $next($request);
        }

//        if user does not have the right role
        return redirect('login')->with('error', 'Maaf anda tidak memiliki akses untuk halaman ini.');
    }
}

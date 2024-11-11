<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna yang sedang login adalah admin
        if (Auth::check() && Auth::user()->usertype == 'admin') {
            return $next($request); // Akses diberikan jika admin
        }
        // Jika bukan admin, arahkan ke halaman home dengan pesan error
        return redirect('home')->with('error', "You don't have admin access.");
    }
}

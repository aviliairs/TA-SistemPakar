<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): mixed
     {
        // Jangan redirect jika user sudah login dan bukan mengakses halaman guest
        if (Auth::check()) {
            $currentRoute = $request->route() ? $request->route()->getName() : '';
            $guestRoutes = ['login', 'registration', 'password.request', 'password.reset']; //route yang dianggap untuk yang belum login

            // Hanya redirect jika benar-benar mengakses halaman guest
            if (in_array($currentRoute, $guestRoutes)) {
                if (Auth::user()->role === 'Admin') {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->role === 'User') {
                    return redirect()->route('diagnosa.pertanyaan');
                }
            }
        }

        return $next($request);
    }
}

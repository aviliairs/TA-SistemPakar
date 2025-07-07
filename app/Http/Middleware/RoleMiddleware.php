<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userRole = Auth::user()->role;

    if ($userRole !== $role) {
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    return $next($request);
    }

    // private function redirectToRoleDashboard($role)
    // {

    // switch ($role) {
    //     case 'Admin':
    //         return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
    //     case 'User':
    //         return redirect()->route('diagnosa.form')->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
    //     default:
    //         return redirect()->route('home.index')->with('error', 'Role tidak dikenali');
    // }
    // }
}

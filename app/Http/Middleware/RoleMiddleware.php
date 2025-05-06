<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $rolesArray = explode('|', $roles); // ← هنا التحويل المهم

        if (!in_array($user->role, explode('|', $roles))) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}

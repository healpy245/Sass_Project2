<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next,$roles): Response
    {
        if (!FacadesAuth::check()) {
            return redirect()->route('login');
        }

        $user = FacadesAuth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }


        return $next($request);
    }
}

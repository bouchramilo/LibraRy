<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BibliothecaireMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login.show');
        }

        if (auth()->user()->role !== 'Bibliothécaire') {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}

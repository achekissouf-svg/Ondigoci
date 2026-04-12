<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BoutiqueMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'boutique') {
            abort(403, 'Accès non autorisé');
        }

        $boutique = Auth::user()->boutique;
        if (!$boutique || $boutique->statut !== 'approuve') {
            // Alternatively, redirect to a pending page
            return redirect()->route('boutique.pending');
        }

        return $next($request);
    }
}

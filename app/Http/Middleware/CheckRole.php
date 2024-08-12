<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // L'utilisateur n'est pas connecté
            return redirect('/login');
        }

        $user = Auth::user();
        if ($user->role != $role) {
            // L'utilisateur n'a pas le bon rôle
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureHasCompany
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        /** @var \App\Models\User|\Spatie\Permission\Traits\HasRoles|null $user */

        // Solo aplica a usuarios "Empresa" y que aún no tienen company
        $isEmpresa = $user && method_exists($user, 'hasRole') && ! $user->hasRole('Empresa');

        if ($isEmpresa && !$user->company) {
            return redirect()
                ->route('empresa.company.show') // tu pantalla para crear/ligarse a una empresa
                ->with('error', 'Primero crea los datos de tu empresa para continuar.');
        }

        return $next($request);
    }
}

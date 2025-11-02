<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        /** @var \App\Models\User|\Spatie\Permission\Traits\HasRoles|null $user */
        $user = Auth::guard('web')->user();

        if (! $user || ! method_exists($user, 'hasRole') || ! $user->hasRole($role)) {
            abort(403);
        }

        return $next($request);
    }
}

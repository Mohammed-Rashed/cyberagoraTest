<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->role !== $this->resolveRole($role)) {
            abort(403);
        }

        return $next($request);
    }

    private function resolveRole(string $role): UserRole
    {
        return match (strtolower($role)) {
            '1', 'admin' => UserRole::Admin,
            '2', 'user' => UserRole::User,
            '3', 'approver' => UserRole::Approver,
            default => abort(403),
        };
    }
}

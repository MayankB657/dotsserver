<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionList;
use App\Models\Role;
use App\Models\UserType;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(404);
        }

        if ($user->usertype == 'user') {
            return $this->handleUserRole($user, $request, $next);
        }

        return $this->handleLevelBasedPermissions($user, $request, $next);
    }

    protected function handleUserRole($user, $request, $next)
    {
        $role = Role::find($user->role_id);

        if (!$role) {
            abort(404);
        }

        $permissionIds = json_decode($role->permissions, true);

        $allowedPermissions = PermissionList::where('for_user_type', 'user')
            ->whereIn('id', $permissionIds)
            ->pluck('route')
            ->toArray();

        $requestedRoute = $request->route()->getName();

        // Check if the route exists in the PermissionList table
        $routeExists = PermissionList::where('route', $requestedRoute)->exists();

        if (!$routeExists && !$this->isRestrictedRoute($requestedRoute, ['client/', 'companies/', 'company/', 'groups/'])) {
            return $next($request);
        }

        if (in_array($requestedRoute, $allowedPermissions)) {
            return $next($request);
        }

        abort(404);
    }

    protected function handleLevelBasedPermissions($user, $request, $next)
    {
        $userType = UserType::where('flag', $user->usertype)->first();

        if (!$userType) {
            abort(404);
        }

        $allowedUserTypes = UserType::where('level', '>=', $userType->level)
            ->pluck('flag')
            ->toArray();

        $allowedPermissions = PermissionList::whereIn('for_user_type', $allowedUserTypes)
            ->pluck('route')
            ->toArray();

        $requestedRoute = $request->route()->getName();

        $routeExists = PermissionList::where('route', $requestedRoute)->exists();

        if (!$routeExists && !$this->isRestrictedRoute($requestedRoute, ['client/', 'company/', 'companies/'])) {
            return $next($request);
        }

        if (in_array($requestedRoute, $allowedPermissions)) {
            return $next($request);
        }

        abort(404);
    }

    protected function isRestrictedRoute(string $route, array $restrictedPrefixes): bool
    {
        foreach ($restrictedPrefixes as $prefix) {
            if (str_starts_with($route, $prefix)) {
                return true;
            }
        }
        return false;
    }
}

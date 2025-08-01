<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class setRolePermission
{
    public function handle($request, Closure $next)
    {
        // Check all possible guards
        $guards = ['web', 'user']; // Add any other guards you use
        
        foreach ($guards as $guard) {
            if ($user = Auth::guard($guard)->user()) {
                $this->loadUserRelationships($user);
                break; // Stop after finding the first authenticated user
            }
        }

        return $next($request);
    }

    protected function loadUserRelationships($user)
    {
        // Eager load roles with their permissions
        $user->loadMissing(['roles.permissions']);
        
        // Get loaded roles
        $roles = $user->roles;
        
        // Process permissions (flatten and unique)
        $permissions = $roles->pluck('permissions')->flatten()->unique('id');
        
        // Set relationships
        $user->setRelation('roles', $roles);
        $user->setRelation('permissions', $permissions);
        
        // Cache permission/role names for quick checking
        $user->cachedPermissions = $permissions->pluck('name')->toArray();
        $user->cachedRoles = $roles->pluck('name')->toArray();
        
        // Add helper methods to user object for this request
        $user->hasPermissionViaRoles = function ($permission) use ($user) {
            return in_array($permission, $user->cachedPermissions);
        };
        
        $user->hasRoleViaRoles = function ($role) use ($user) {
            return in_array($role, $user->cachedRoles);
        };
    }
}
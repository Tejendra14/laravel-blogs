<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'slug'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function syncPermissions($permissions)
    {
        // Accept array of permission IDs or slugs
        $permissionIds = [];
        
        foreach ((array)$permissions as $permission) {
            if (is_numeric($permission)) {
                $permissionIds[] = $permission;
            } elseif (is_string($permission)) {
                $perm = Permission::where('slug', $permission)->first();
                if ($perm) $permissionIds[] = $perm->id;
            }
        }
        
        $this->permissions()->sync($permissionIds);
        return $this;
    }

    public function givePermissionTo($permission)
    {
        if (is_numeric($permission)) {
            $this->permissions()->attach($permission);
        } elseif (is_string($permission)) {
            $perm = Permission::where('slug', $permission)->first();
            if ($perm) $this->permissions()->attach($perm->id);
        }
        return $this;
    }

    public function revokePermissionTo($permission)
    {
        if (is_numeric($permission)) {
            $this->permissions()->detach($permission);
        } elseif (is_string($permission)) {
            $perm = Permission::where('slug', $permission)->first();
            if ($perm) $this->permissions()->detach($perm->id);
        }
        return $this;
    }
}
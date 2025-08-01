<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user'); // Explicit pivot table
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function creator()
    {
        return $this->belongsTo(SuperAdmin::class, 'created_by');
    }

    // Authorization
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function($q) use ($permission) {
            $q->where('name', $permission);
        })->exists();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAuthor()
    {
        return $this->role === 'author';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get all role names as a simple array
     */
    public function getRoleNames()
    {
        return $this->roles->pluck('name');
    }

// app/Models/User.php

public function getAllPermissions()
{
    // Get direct permissions
    $directPermissions = $this->permissions ?? collect();
    
    // Get permissions through roles
    $rolePermissions = $this->roles->flatMap(function ($role) {
        return $role->permissions ?? collect();
    });
    
    return $directPermissions->merge($rolePermissions)->unique('id');
}

public function hasPermissionTo($permission)
{
    if (is_numeric($permission)) {
        return $this->getAllPermissions()->contains('id', $permission);
    }
    
    if (is_string($permission)) {
        return $this->getAllPermissions()->contains('slug', $permission);
    }
    
    return $this->getAllPermissions()->contains($permission);
}

public function hasAnyPermission($permissions)
{
    foreach ((array)$permissions as $permission) {
        if ($this->hasPermissionTo($permission)) {
            return true;
        }
    }
    return false;
}
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Admin Role
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            // 'slug' => 'admin',
            'description' => 'Administrator with full system access'
        ]);

        // Create Author Role
        $authorRole = Role::firstOrCreate([
            'name' => 'Author',
            // 'slug' => 'author',
            'description' => 'Can create and manage their own content'
        ]);

        // Assign all permissions to Admin
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // Assign specific permissions to Author
        $authorPermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'view%')
                  ->orWhere('name', 'like', 'create%')
                  ->orWhere('name', 'like', 'edit%')
                  ->orWhere('name', 'like', 'delete%')
                  ->orWhere('name', 'like', 'publish%')
                  ->orWhere('name', 'like', 'approve%');
        })->where(function($query) {
            $query->where('name', 'like', '%post%')
                  ->orWhere('name', 'like', '%category%')
                  ->orWhere('name', 'like', '%tag%')
                  ->orWhere('name', 'like', '%comment%');
        })->pluck('id');

        $authorRole->permissions()->sync($authorPermissions);

        // Assign roles to users (assuming you have users with emails)
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser) {
            $adminUser->roles()->sync([$adminRole->id]);
        }

        $authorUser = User::where('email', 'author@gmail.com')->first();
        if ($authorUser) {
            $authorUser->roles()->sync([$authorRole->id]);
        }
    }
}
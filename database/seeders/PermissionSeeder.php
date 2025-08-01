<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create permissions for each model
        $models = [
            'user',
            'role',
            'permission',
            'post',
            'category',
            'tag',
            'comment',
            'setting'
        ];

        $actions = [
            'view',
            'create',
            'edit',
            'delete',
            'publish',
            'approve'
        ];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                // Skip publish and approve for some models
                if (in_array($action, ['publish', 'approve']) && !in_array($model, ['post', 'comment'])) {
                    continue;
                }

                $permissionName = "{$action} {$model}";
                $slug = Str::slug("{$action}-{$model}");
                
                Permission::firstOrCreate([
                    'slug' => $slug
                ], [
                    'name' => $permissionName,
                    'description' => "Allows user to {$action} {$model}s",
                    'slug' => $slug
                ]);
            }
        }

        // Additional special permissions
        $specialPermissions = [
            'manage system' => 'Allows full system management',
            'access admin panel' => 'Allows access to admin dashboard',
            'impersonate users' => 'Allows impersonating other users',
            'manage settings' => 'Allows managing system settings',
            'backup database' => 'Allows creating database backups',
            'restore database' => 'Allows restoring database from backups',
            'view audit logs' => 'Allows viewing system audit logs'
        ];

        foreach ($specialPermissions as $name => $description) {
            $slug = Str::slug($name);
            
            Permission::firstOrCreate([
                'slug' => $slug
            ], [
                'name' => $name,
                'description' => $description,
                'slug' => $slug
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasicAdminPermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        $permissions = [
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',
            'post list',
            'post create',
            'post edit',
            'post delete',
            'category list',
            'category create',
            'category edit',
            'category delete',
            'mentor list',
            'mentor create',
            'mentor edit',
            'mentor delete',
            'page-settings list',
            'page-settings edit',
            'join-our-networks list',
            'appointment create',
            'appointment edit',
            'appointment delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'status' => 'ACT']);
        }

        $adminRole = Role::create(['name' => 'Admin', 'status' => 'ACT', 'code' => 'ADM']);
        foreach ($permissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
        $superAdminRole = Role::create(['name' => 'Super Admin', 'status' => 'ACT', 'code' => 'SUP']);
        Role::create(['name' => 'Public Users', 'status' => 'ACT', 'code' => 'PUB']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Punrong - Super Admin',
            'email' => 'punrongrany1999@gmail.com',
            'status' => 'ACT',
        ]);
        $user->assignRole($superAdminRole);
        $user = \App\Models\User::factory()->create([
            'name' => 'Punrong - Admin User',
            'email' => 'punrongrany@gmail.com',
            'status' => 'ACT',
        ]);
        $user->assignRole($adminRole);
    }
}

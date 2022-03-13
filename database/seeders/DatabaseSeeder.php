<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Permission
        Permission::create([
            'name' => 'Browse',
            'guard_name' => 'api'
        ]);
        Permission::create([
            'name' => 'Read',
            'guard_name' => 'api'
        ]);
        Permission::create([
            'name' => 'Edit',
            'guard_name' => 'api'
        ]);
        Permission::create([
            'name' => 'Add',
            'guard_name' => 'api'
        ]);
        Permission::create([
            'name' => 'Delete',
            'guard_name' => 'api'
        ]);

        // Role Admin
        $role_admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'api'
        ]);
        for($i = 1; $i <= 5; $i++) {
            $role_admin->givePermissionTo($i);
        }
        // Role Pendaftar
        $role_pendaftar = Role::create([
            'name' => 'Pendaftar',
            'guard_name' => 'api'
        ]);
        for($i = 1; $i <= 2; $i++) {
            $role_pendaftar->givePermissionTo($i);
        }

        // User Programmer
        $programmer = User::create([
            'name'     => 'Programmer',
            'email'    => 'programmer@email.com',
            'password' => Hash::make('password'),
        ]);
        $programmer->syncRoles($role_admin);
        $permissionsByRole = $programmer->getPermissionsViaRoles()->pluck('id');
        $programmer->syncPermissions($permissionsByRole);

        // User Pendaftar
        $pendaftar = User::create([
            'name'     => 'Test Pendaftar',
            'email'    => 'pendaftar@email.com',
            'password' => Hash::make('password'),
        ]);
        $pendaftar->syncRoles($role_pendaftar);
        $permissionsByRole = $pendaftar->getPermissionsViaRoles()->pluck('id');
        $pendaftar->syncPermissions($permissionsByRole);

        Artisan::call('passport:install');
    }
}

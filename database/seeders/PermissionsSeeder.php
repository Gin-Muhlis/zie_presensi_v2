<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'view sessionstarts']);
        Permission::create(['name' => 'list presences']);
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'update students']);
        Permission::create(['name' => 'list studentabsences']);
        Permission::create(['name' => 'view studentabsences']);
        Permission::create(['name' => 'create studentabsences']);
        // Membuat role siswa
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'siswa']);
        $userRole->givePermissionTo($currentPermissions);

        Permission::create(['name' => 'view sessionends']);
        Permission::create(['name' => 'create sessionstarts']);
         // Membuat role guru
         $currentPermissions = Permission::all();
         $userRole = Role::create(['name' => 'guru']);
         $userRole->givePermissionTo($currentPermissions);

        Permission::create(['name' => 'list classstudents']);
        Permission::create(['name' => 'view classstudents']);
        Permission::create(['name' => 'create classstudents']);
        Permission::create(['name' => 'update classstudents']);
        Permission::create(['name' => 'delete classstudents']);
        
        Permission::create(['name' => 'view presences']);
        Permission::create(['name' => 'create presences']);
        Permission::create(['name' => 'update presences']);
        Permission::create(['name' => 'delete presences']);

        Permission::create(['name' => 'list sessionends']);
        Permission::create(['name' => 'update sessionends']);
        Permission::create(['name' => 'delete sessionends']);

        Permission::create(['name' => 'list sessionstarts']);
        Permission::create(['name' => 'update sessionstarts']);
        Permission::create(['name' => 'delete sessionstarts']);

        Permission::create(['name' => 'list students']);
        Permission::create(['name' => 'delete students']);

        Permission::create(['name' => 'update studentabsences']);
        Permission::create(['name' => 'delete studentabsences']);

        Permission::create(['name' => 'list teachers']);
        Permission::create(['name' => 'view teachers']);
        Permission::create(['name' => 'create teachers']);
        Permission::create(['name' => 'update teachers']);
        Permission::create(['name' => 'delete teachers']);


        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}

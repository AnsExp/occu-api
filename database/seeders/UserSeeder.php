<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate([
            'email' => 'admin@email.com'
        ], [
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin')
        ]);

        foreach (config('occu_roles', []) as $role) {
            Role::updateOrCreate(['name' => $role], ['name' => $role]);
        }

        foreach (config('occu_permissions', []) as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['name' => $permission]);
        }

        foreach (config('occu_roles_permissions', []) as $role => $permissions) {
            $roleModel = Role::findByName($role);
            $roleModel->syncPermissions($permissions);
        }

        $user->syncRoles('administrator');
    }
}

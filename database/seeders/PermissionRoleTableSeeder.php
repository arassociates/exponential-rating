<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $admin_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 6) != 'super_';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 8) == 'profile_';
        });
        Role::findOrFail(3)->permissions()->sync($user_permissions);
        Role::findOrFail(4)->permissions()->sync($user_permissions);
    }
}

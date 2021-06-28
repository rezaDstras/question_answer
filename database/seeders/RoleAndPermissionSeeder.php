<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create role by defined default data in config->permission.php

        //if don't exist in database
        if (Role::where('name', config('permission.default_roles')[0])->count() <1){
            foreach (config('permission.default_roles') as $role){
                Role::create([
                    'name' => $role,
                ]);
            }
        }

        //create permission by defined default data in config->permission.php
        //if don't exist in database
        if (Permission::where('name', config('permission.default_permission')[0])->count() <1) {
            foreach (config('permission.default_permission') as $permission) {
                Permission::create([
                    'name' => $permission,
                ]);
            }
        }

    }
}

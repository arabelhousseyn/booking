<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            'name' => 'root',
            'guard_name' => 'admin',
            'is_protected' => true,
        ];

        $permissions = Permission::all();

        $role = Role::create($roles);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}

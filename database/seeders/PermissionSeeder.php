<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = Permissions::getValues();


        $permissions = collect($permissions)->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        Permission::insert($permissions);
    }
}

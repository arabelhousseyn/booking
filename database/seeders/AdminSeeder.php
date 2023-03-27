<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::factory()->create(['email' => 'admin@admin.com', 'password' => Hash::make('password')]);
        $role = Role::where('name', '=', 'root')->first();
        $admin->assignRole($role);
    }
}

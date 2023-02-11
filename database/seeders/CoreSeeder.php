<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Core;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $adminId = Admin::factory()->create()->id;

        Core::create([
            'commission' => 1,
            'commission_updated_by' => $adminId,
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\House;
use App\Models\Reason;
use App\Models\Review;
use App\Models\Seller;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Admin::factory()->count(5)->create();
        User::factory()->count(10)->create();
        UserDocument::factory()->count(10)->create();
        Seller::factory()->count(10)->create();
        House::factory()->count(100)->create();
        Vehicle::factory()->count(100)->create();
        VehicleDocument::factory()->count(100)->create();
        Favorite::factory()->count(30)->create();
        Booking::factory()->count(100)->create();
        Review::factory()->count(20)->create();
        Reason::factory()->count(3)->create();

        $this->call([
            CoreSeeder::class,
        ]);
    }
}

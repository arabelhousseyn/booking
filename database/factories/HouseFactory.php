<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\House;
use App\Models\Seller;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => Seller::factory(),
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'coordinates' => '36.1580,1.3373',
            'price' => $this->faker->randomFloat(8, 1000, 100000),
            'rooms' => $this->faker->numberBetween(1, 10),
            'has_wifi' => $this->faker->randomElement([false, true]),
            'parking_station' => $this->faker->randomElement([false, true]),
            'availability_start_date' => $start_date = Carbon::now()->format('Y-m-d'),
            'availability_end_date' => Carbon::parse($start_date)->modify('+ 2 days'),
            'status' => Status::BOOKED,
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (House $house) {
            $house->update(['status' => $this->faker->randomElement([Status::PENDING, Status::BOOKED, Status::DECLINED, Status::PUBLISHED])]);
        });
    }
}

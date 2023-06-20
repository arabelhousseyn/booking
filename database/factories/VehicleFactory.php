<?php

namespace Database\Factories;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Enums\Status;
use App\Models\Seller;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'dahabia' => true,
            'debit_card' => true,
        ];
        return [
            'seller_id' => Seller::factory(),
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'coordinates' => '36.1580,1.3373',
            'price' => $this->faker->randomFloat(8, 1000, 100000),
            'places' => $this->faker->numberBetween(1, 10),
            'motorisation' => $this->faker->randomElement([Motorisation::DIESEL, Motorisation::GASOLINE, Motorisation::GAS]),
            'gearbox' => $this->faker->randomElement([GearBox::AUTOMATIC, GearBox::MANUAL]),
            'is_full' => $this->faker->randomElement([false, true]),
            'payments_accepted' => json_encode($data),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Vehicle $vehicle) {
            $vehicle->update(['status' => $this->faker->randomElement([Status::PENDING, Status::BOOKED, Status::DECLINED, Status::PUBLISHED])]);
        });
    }
}

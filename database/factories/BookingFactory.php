<?php

namespace Database\Factories;

use App\Enums\PaymentType;
use App\Models\House;
use App\Models\Seller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = $this->faker->randomElement([House::factory()->create(), Vehicle::factory()->create()]);
        return [
            'user_id' => User::factory(),
            'seller_id' => Seller::factory(),
            'bookable_type' => $model->getMorphClass(),
            'bookable_id' => $model->id,
            'payment_type' => $this->faker->randomElement([PaymentType::DAHABIA, PaymentType::VISA, PaymentType::MASTER_CARD]),
            'original_price' => $this->faker->randomFloat(8, 1000, 100000),
            'calculated_price' => $this->faker->randomFloat(8, 1000, 100000),
            'commission' => $this->faker->numberBetween(1, 100),
            'caution' => $this->faker->randomFloat(8, 1000, 100000),
            'start_date' => ($date = Carbon::now())->toDateTimeString(),
            'end_date' => (clone $date)->modify('+ 3days'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('###'),
            'description' => $this->faker->sentence,
            'value_type' => $this->faker->randomElement([CouponValueType::STATIC, CouponValueType::PERCENTAGE]),
            'value' => $this->faker->numberBetween(1, 100),
            'type' => $type = $this->faker->randomElement([CouponType::CUSTOM, CouponType::PERMANENT]),
            'system_type' => $this->faker->randomElement([CouponSystemType::HOUSE, CouponSystemType::VEHICLE, CouponSystemType::ALL]),
            'start_date' => ($type == CouponType::CUSTOM) ? '2023-03-14' : null,
            'end_date' => ($type == CouponType::CUSTOM) ? '2023-04-30' : null,
            'usage_limit' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement([CouponStatus::ACTIVE, CouponStatus::INACTIVE]),
        ];
    }
}

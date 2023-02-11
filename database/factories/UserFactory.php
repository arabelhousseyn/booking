<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'email_verified_at' => now(),
            'phone' => $this->faker->unique()->phoneNumber,
            'phone_verified_at' => now(),
            'can_rent_vehicle' => $this->faker->randomElement([true,false]),
            'coordinates' => '36.7538,3.0588',
            'validated_at' => now(),
            'validated_by' => Admin::factory(),
            'password' => Hash::make('password'),
        ];
    }


    public function unverified(): self
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

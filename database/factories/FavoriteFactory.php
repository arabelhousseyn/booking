<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
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
            'favorable_type' => $model->getMorphClass(),
            'favorable_id' => $model->id,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Enums\ModelType;
use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            'reviewable_type' => $model->getMorphClass(),
            'reviewable_id' => $model->id,
            'rating' => $this->faker->numberBetween(1,5),
        ];
    }
}

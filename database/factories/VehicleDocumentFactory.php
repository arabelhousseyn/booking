<?php

namespace Database\Factories;

use App\Enums\VehicleDocumentType;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleDocument>
 */
class VehicleDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'document_type' => $this->faker->randomElement([VehicleDocumentType::INSURANCE, VehicleDocumentType::GREY_CARD, VehicleDocumentType::TECHNICAL_CONTROL]),
            'document_url' => $this->faker->imageUrl,
            'expiry_date' => $this->faker->date('Y-m-d'),
        ];
    }
}

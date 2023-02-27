<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vehicle = Vehicle::factory()->create();
    }

    public function test_store_favorites__case01() // standard case
    {
        $inputs = [
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ];
        $this->authenticated()
            ->json('post', "$this->endpoint/store-favorites", $inputs)
            ->assertNoContent();

        // check if the favorite was inserted

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ]);
    }

    public function test_store_favorites__case02() // case when the favorable id is invalid
    {
        $inputs = [
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => Str::uuid(),
        ];
        $this->authenticated()
            ->json('post', "$this->endpoint/store-favorites", $inputs)
            ->assertJsonValidationErrors(['favorable_id']);
    }
}

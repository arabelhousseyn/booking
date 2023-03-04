<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private Vehicle $vehicle;
    private House $house;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vehicle = Vehicle::factory()->create();
        $this->house = House::factory()->create();
    }

    public function test_store_favorites__case01() // standard case
    {
        $inputs = [
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ];
        $this->authenticated()
            ->json('post', "$this->endpoint/store-favorite", $inputs)
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
            ->json('post', "$this->endpoint/store-favorite", $inputs)
            ->assertJsonValidationErrors(['favorable_id']);
    }

    public function test_get_favorites()
    {
        Favorite::create([
            'user_id' => $this->user->getKey(),
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ]);

        Favorite::create([
            'user_id' => $this->user->getKey(),
            'favorable_type' => $this->house->getMorphClass(),
            'favorable_id' => $this->house->getKey(),
        ]);

        $this->authenticated()
            ->json('get', "$this->endpoint/favorites")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'favorable_id',
                        'favorable_type',
                        'favorable',
                    ],
                ],
            ]);
    }

    public function test_destroy_favorite()
    {
        $favorite = Favorite::create([
            'user_id' => $this->user->getKey(),
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ]);

        $this->authenticated()
            ->json('delete', "$this->endpoint/destroy-favorite/{$this->user->id}/{$favorite->id}")
            ->assertNoContent();

        // check if the favorite has been deleted
        $this->assertModelMissing($favorite);
    }

    public function test_scope_binding_user_favorite()
    {
        $user = User::factory()->create();
        $favorite = Favorite::create([
            'user_id' => $this->user->getKey(),
            'favorable_type' => $this->vehicle->getMorphClass(),
            'favorable_id' => $this->vehicle->getKey(),
        ]);

        $this->authenticated()
            ->json('delete', "$this->endpoint/destroy-favorite/{$user->id}/{$favorite->id}")
            ->assertNotFound();
    }
}
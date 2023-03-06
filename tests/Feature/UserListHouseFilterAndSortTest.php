<?php

namespace Tests\Feature;

use App\Models\House;
use Database\Seeders\CoreSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserListHouseFilterAndSortTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private Collection $houses;

    protected function setUp(): void
    {
        parent::setUp();

        House::query()->delete();

        $this->houses = House::factory()->count(3)->sequence(
            ['title' => 'a', 'description' => 'a', 'price' => 10, 'rooms' => 1, 'has_wifi' => false, 'parking_station' => false],
            ['title' => 'b', 'description' => 'b', 'price' => 20, 'rooms' => 2, 'has_wifi' => true, 'parking_station' => true],
            ['title' => 'c', 'description' => 'c', 'price' => 30, 'rooms' => 3, 'has_wifi' => true, 'parking_station' => true]
        )->create();

        $this->seed(CoreSeeder::class);
    }

    /****************************************************   filters   ***************************************************************/

    public function test_title_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[title]=a")
            ->assertJsonCount(1, 'data');
    }

    public function test_description_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[description]=a")
            ->assertJsonCount(1, 'data');
    }

    public function test_price_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[price]=10,20")
            ->assertJsonCount(2, 'data');
    }

    public function test_rooms_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[rooms]=1")
            ->assertJsonCount(1, 'data');
    }

    public function test_has_wifi_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[has_wifi]=true")
            ->assertJsonCount(2, 'data');
    }

    public function test_parking_station_filter()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[parking_station]=true")
            ->assertJsonCount(2, 'data');
    }

    /****************************************************   sorts   ***************************************************************/

    public function test_title_sort()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=title")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id],['id' => $this->houses[1]->id],['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-title")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id],['id' => $this->houses[1]->id],['id' => $this->houses[0]->id]]]);
    }

    public function test_description_sort()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=description")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id],['id' => $this->houses[1]->id],['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-description")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id],['id' => $this->houses[1]->id],['id' => $this->houses[0]->id]]]);
    }

    public function test_price_sort()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=price")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id],['id' => $this->houses[1]->id],['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-price")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id],['id' => $this->houses[1]->id],['id' => $this->houses[0]->id]]]);
    }

    public function test_rooms_sort()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=rooms")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id],['id' => $this->houses[1]->id],['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-rooms")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id],['id' => $this->houses[1]->id],['id' => $this->houses[0]->id]]]);
    }
}

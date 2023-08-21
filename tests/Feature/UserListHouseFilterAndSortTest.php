<?php

namespace Tests\Feature;

use App\Enums\Status;
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
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[title]=a", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_description_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[description]=a", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_price_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[price]=10,20", $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_rooms_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[rooms]=1", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_has_wifi_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[has_wifi]=true", $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_parking_station_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?filter[parking_station]=true", $input)
            ->assertJsonCount(2, 'data');
    }

    /****************************************************   sorts   ***************************************************************/

    public function test_title_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=title", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-title", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[0]->id]]]);
    }

    public function test_description_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=description", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-description", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[0]->id]]]);
    }

    public function test_price_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=price", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-price", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[0]->id]]]);
    }

    public function test_rooms_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->houses[0]->update(['status' => Status::PUBLISHED]);
        $this->houses[1]->update(['status' => Status::PUBLISHED]);
        $this->houses[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=rooms", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[0]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses?sort=-rooms", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->houses[2]->id], ['id' => $this->houses[1]->id], ['id' => $this->houses[0]->id]]]);
    }
}

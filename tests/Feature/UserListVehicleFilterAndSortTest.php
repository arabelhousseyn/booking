<?php

namespace Tests\Feature;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Enums\Status;
use App\Models\Vehicle;
use Database\Seeders\CoreSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserListVehicleFilterAndSortTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private Collection $vehicles;

    protected function setUp(): void
    {
        parent::setUp();

        Vehicle::query()->delete();

        $this->vehicles = Vehicle::factory()->count(3)->sequence(
            ['title' => 'a', 'description' => 'a', 'price' => 10, 'places' => 1, 'motorisation' => Motorisation::DIESEL, 'gearbox' => GearBox::AUTOMATIC, 'is_full' => false],
            ['title' => 'b', 'description' => 'b', 'price' => 20, 'places' => 2, 'motorisation' => Motorisation::GAS, 'gearbox' => GearBox::MANUAL, 'is_full' => true],
            ['title' => 'c', 'description' => 'c', 'price' => 30, 'places' => 3, 'motorisation' => Motorisation::GASOLINE, 'gearbox' => GearBox::AUTOMATIC, 'is_full' => true]
        )->create(['availability_start_date' => '2023-08-21', 'availability_end_date' => '2023-08-22']);

        $this->seed(CoreSeeder::class);
    }

    /****************************************************   filters   ***************************************************************/

    public function test_title_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[title]=a", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_description_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[description]=a", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_price_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[price]=10,20", $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_places_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[places]=1", $input)
            ->assertJsonCount(1, 'data');
    }

    public function test_motorisation_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[motorisation]=".Motorisation::GAS, $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_gearbox_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[gearbox]=".GearBox::AUTOMATIC, $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_is_full_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[is_full]=true", $input)
            ->assertJsonCount(2, 'data');
    }

    public function test_status_filter()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[status]=".Status::PUBLISHED, $input)
            ->assertJsonCount(3, 'data');
    }

    /****************************************************   sorts   ***************************************************************/

    public function test_title_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=title", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-title", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[0]->id]]]);
    }

    public function test_description_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=description", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-description", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[0]->id]]]);
    }

    public function test_price_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=price", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-price", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[0]->id]]]);
    }

    public function test_places_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=places", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-places", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[0]->id]]]);
    }

    public function test_motorisation_sort()
    {
        $input = [
            'start_date' => '2023-08-21',
            'end_date' => '2023-08-22',
        ];

        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=motorisation", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-motorisation", $input)
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id], ['id' => $this->vehicles[1]->id], ['id' => $this->vehicles[0]->id]]]);
    }
}

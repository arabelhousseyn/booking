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
            ['title' => 'a', 'description' => 'a', 'price' => 10 , 'places' => 1, 'motorisation' => Motorisation::DIESEL, 'gearbox' => GearBox::AUTOMATIC, 'is_full' => false],
            ['title' => 'b', 'description' => 'b', 'price' => 20, 'places' => 2, 'motorisation' => Motorisation::GASOLINE, 'gearbox' => GearBox::MANUAL, 'is_full' => true],
            ['title' => 'c', 'description' => 'c', 'price' => 30,'places' => 3, 'motorisation' => Motorisation::MATZOT, 'gearbox' => GearBox::AUTOMATIC, 'is_full' => true]
        )->create();

        $this->seed(CoreSeeder::class);
    }

    /****************************************************   filters   ***************************************************************/

    public function test_title_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[title]=a")
            ->assertJsonCount(1, 'data');
    }

    public function test_description_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[description]=a")
            ->assertJsonCount(1, 'data');
    }

    public function test_price_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[price]=10,20")
            ->assertJsonCount(2, 'data');
    }

    public function test_places_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[places]=1")
            ->assertJsonCount(1, 'data');
    }

    public function test_motorisation_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[motorisation]=" . Motorisation::MATZOT)
            ->assertJsonCount(1, 'data');
    }

    public function test_gearbox_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[gearbox]=" . GearBox::AUTOMATIC)
            ->assertJsonCount(2, 'data');
    }

    public function test_is_full_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[is_full]=true")
            ->assertJsonCount(2, 'data');
    }

    public function test_status_filter()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?filter[status]=" . Status::PUBLISHED)
            ->assertJsonCount(3, 'data');
    }

    /****************************************************   sorts   ***************************************************************/

    public function test_title_sort()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=title")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-title")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[0]->id]]]);
    }

    public function test_description_sort()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=description")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-description")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[0]->id]]]);
    }

    public function test_price_sort()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=price")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-price")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[0]->id]]]);
    }

    public function test_places_sort()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=places")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-places")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[0]->id]]]);
    }

    public function test_motorisation_sort()
    {
        $this->vehicles[0]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[1]->update(['status' => Status::PUBLISHED]);
        $this->vehicles[2]->update(['status' => Status::PUBLISHED]);
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=motorisation")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[0]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[2]->id]]]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles?sort=-motorisation")
            ->assertJsonCount(3, 'data')
            ->assertJson(['data' => [['id' => $this->vehicles[2]->id],['id' => $this->vehicles[1]->id],['id' => $this->vehicles[0]->id]]]);
    }
}

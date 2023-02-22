<?php

namespace Tests\Feature;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Enums\VehicleDocumentType;
use App\Models\House;
use App\Models\Seller;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/sellers';
    private Seller $seller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::factory()->create();
    }

    public function test_store_vehicle()
    {
        Storage::fake('public');
        $inputs = [
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'coordinates' => '36.7538,3.0588',
            'price' => 5000.00,
            'places' => $this->faker->numberBetween(1, 5),
            'motorisation' => Motorisation::DIESEL,
            'gearbox' => GearBox::AUTOMATIC,
            'is_full' => $this->faker->boolean,
            'payments_accepted' => '{ "debit_card": true, "dahabia": true}',
            'photos' => [
                UploadedFile::fake()->image('image.png'),
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/vehicle/{$this->seller->id}", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'places',
                    'motorisation',
                    'price',
                    'gearbox',
                    'is_full',
                    'payments_accepted',
                    'status',
                    'photo',
                    'photo_thumb',
                    'photos',
                ],
            ]);
    }

    public function test_store_seller_vehicle__case01() // without previous documents uploaded
    {
        VehicleDocument::query()->delete();

        Storage::fake('public');

        $vehicle = Vehicle::factory()->create();

        $inputs = [
            'documents' => [
                [
                    'document_type' => VehicleDocumentType::INSURANCE,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                    'expiry_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'document_type' => VehicleDocumentType::GREY_CARD,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                    'expiry_date' => Carbon::now()->format('Y-m-d'),
                ],
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/vehicle/{$vehicle->seller_id}/{$vehicle->id}", $inputs)
            ->assertNoContent();

        // check the number in the database

        $this->assertDatabaseCount('vehicle_documents', 2);
    }

    public function test_store_seller_vehicle__case02() // with previous documents uploaded
    {
        VehicleDocument::query()->delete();

        Storage::fake('public');

        $vehicle = Vehicle::factory()->has(VehicleDocument::factory(), 'documents')->create();

        $inputs = [
            'documents' => [
                [
                    'document_type' => VehicleDocumentType::INSURANCE,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                    'expiry_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'document_type' => VehicleDocumentType::GREY_CARD,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                    'expiry_date' => Carbon::now()->format('Y-m-d'),
                ],
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/vehicle/{$vehicle->seller_id}/{$vehicle->id}", $inputs)
            ->assertBadRequest()
            ->assertJson([
                'message' => trans('exceptions.file_uploaded'),
            ]);
    }

    public function test_get_vehicles()
    {
        $vehicle = Vehicle::factory()->count(5)->create(['seller_id' => $this->seller->id]);

        $this->authenticated()
            ->json('get', "$this->endpoint/vehicle/{$this->seller->id}")
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_store_house()
    {
        Storage::fake('public');
        $inputs = [
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'coordinates' => '36.7538,3.0588',
            'price' => 5000.00,
            'rooms' => $this->faker->numberBetween(1, 5),
            'has_wifi' => $this->faker->boolean,
            'parking_station' => $this->faker->boolean,
            'photos' => [
                UploadedFile::fake()->image('image.png'),
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/house/{$this->seller->id}", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'price',
                    'rooms',
                    'has_wifi',
                    'parking_station',
                    'photo',
                    'photo_thumb',
                    'photos',
                ],
            ]);
    }

    public function test_get_houses()
    {
        $house = House::factory()->count(5)->create(['seller_id' => $this->seller->id]);

        $this->authenticated()
            ->json('get', "$this->endpoint/house/{$this->seller->id}")
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }
}

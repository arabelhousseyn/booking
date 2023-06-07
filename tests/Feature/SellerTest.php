<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Enums\VehicleDocumentType;
use App\Models\Booking;
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
        $this->seller = Seller::factory()->create(['email' => 'hello@gmail.com']);
    }

    public function authenticated(): TestCase
    {
        return $this->actingAs($this->seller);
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
            ->json('post', "$this->endpoint/vehicle", $inputs)
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

    public function test_get_vehicles()
    {
        $vehicle = Vehicle::factory()->count(5)->create(['seller_id' => $this->seller->id]);

        $this->authenticated()
            ->json('get', "$this->endpoint/vehicle")
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
            ->json('post', "$this->endpoint/house", $inputs)
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
            ->json('get', "$this->endpoint/house")
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_update_profile()
    {
        $inputs = [
            'first_name' => $this->faker->firstName,
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/profile", $inputs)
            ->assertNoContent();

        // check if the input has been update in the database

        $this->assertDatabaseHas('sellers', [
            'id' => $this->seller->id,
            'first_name' => $inputs['first_name'],
        ]);
    }

    public function test_profile()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/profile")
            ->assertOk();
    }

    public function test_update_password__case01() // standard case
    {
        $inputs = [
            'old_password' => 'password',
            'password' => 'hocine.12',
            'password_confirmation' => 'hocine.12',
        ];

        $this->authenticated()
            ->json('put', "$this->endpoint/password", $inputs)
            ->assertNoContent();
    }

    public function test_update_password__case02() // when the old password is wrong
    {
        $inputs = [
            'old_password' => 'password1',
            'password' => 'hocine.12',
            'password_confirmation' => 'hocine.12',
        ];

        $this->authenticated()
            ->json('put', "$this->endpoint/password", $inputs)
            ->assertBadRequest()
            ->assertJson([
                'message' => trans('exceptions.wrong_password', ['state' => trans("nominations.old")]),
            ]);
    }

    public function test_list_bookings()
    {
        Booking::factory()->count(4)->create(['seller_id' => $this->seller->id]);
        $this->authenticated()
            ->json('get', "$this->endpoint/bookings")
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'bookable_type',
                        'bookable_id',
                        'bookable',
                        'payment_type',
                        'original_price',
                        'calculated_price',
                        'start_date',
                        'end_date',
                        'status',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_view_booking()
    {
        $booking = Booking::factory()->create(['seller_id' => $this->seller->id]);
        $this->authenticated()
            ->json('get', "$this->endpoint/booking/{$booking->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'bookable_type',
                    'bookable_id',
                    'bookable',
                    'payment_type',
                    'original_price',
                    'calculated_price',
                    'start_date',
                    'end_date',
                    'status',
                    'created_at',
                ],
            ]);
    }

    public function test_terminate_booking__case01() // standard case
    {
        Storage::fake('public');

        $booking = Booking::factory()->create(['seller_id' => $this->seller->id]);
        $booking->update(['status' => BookingStatus::ACCEPTED]);

        $payload = [
            'note' => $this->faker->sentence,
            'photos' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/terminate-booking/{$booking->id}", $payload)
            ->assertNoContent();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->getKey(),
            'status' => BookingStatus::COMPLETED,
        ]);
    }

    public function test_terminate_booking__case02() // when the status is pending
    {
        Storage::fake('public');

        $booking = Booking::factory()->create(['seller_id' => $this->seller->id]);

        $payload = [
            'note' => $this->faker->sentence,
            'photos' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/terminate-booking/{$booking->id}", $payload)
            ->assertForbidden();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->getKey(),
            'status' => BookingStatus::PENDING,
        ]);
    }

    public function test_terminate_booking__case03() // when the booking doesn't belong to the seller
    {
        Storage::fake('public');

        $booking = Booking::factory()->create();
        $booking->update(['status' => BookingStatus::ACCEPTED]);

        $payload = [
            'note' => $this->faker->sentence,
            'photos' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/terminate-booking/{$booking->id}", $payload)
            ->assertForbidden();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->getKey(),
            'status' => BookingStatus::ACCEPTED,
        ]);
    }
}

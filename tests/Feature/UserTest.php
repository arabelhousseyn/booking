<?php

namespace Tests\Feature;

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\ReasonTypes;
use App\Enums\Status;
use App\Events\BookingDeclined;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Core;
use App\Models\Coupon;
use App\Models\Favorite;
use App\Models\House;
use App\Models\Reason;
use App\Models\Review;
use App\Models\User;
use App\Models\Vehicle;
use Database\Seeders\CoreSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private Vehicle $vehicle;
    private House $house;
    private Collection $vehicles;
    private Collection $houses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vehicle = Vehicle::factory()->create();
        $this->house = House::factory()->create();
        $this->vehicles = Vehicle::factory()->count(10)->has(Review::factory(), 'reviews')->create();
        $this->houses = House::factory()->count(10)->has(Review::factory(), 'reviews')->create();

        House::query()->update(['status' => Status::PUBLISHED]);
        Vehicle::query()->update(['status' => Status::PUBLISHED]);

        $this->seed(CoreSeeder::class);
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

    public function test_update_profile()
    {
        $inputs = [
            'first_name' => $this->faker->firstName,
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/profile", $inputs)
            ->assertNoContent();

        // check if the input has been update in the database

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
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

    /*************** with auth **************/

    public function test_list_vehicles__case01() // same point between the user and the vehicles
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles")
            ->assertOk()
            ->assertJsonCount(15, 'data');
    }

    public function test_list_vehicles__case02() // test less than the KM of core
    {
        Vehicle::query()->delete();
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);

        Vehicle::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_list_vehicles__case03() // test greater than the KM of core
    {
        Vehicle::query()->delete();
        Vehicle::factory()->create(['coordinates' => '36.7538,3.0588']);
        Vehicle::factory()->create(['coordinates' => '36.7538,3.0588']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);

        Vehicle::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles")
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_list_houses__case01() // same point between the user and the houses
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses")
            ->assertOk()
            ->assertJsonCount(15, 'data');
    }

    public function test_list_houses__case02() // test less than the KM of core
    {
        House::query()->delete();
        House::factory()->create(['coordinates' => '36.5081,1.3078']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);

        House::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_list_house__case03() // test greater than the KM of core
    {
        House::query()->delete();
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);

        House::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses")
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    /*************** without auth **************/

    public function test_list_vehicles_without_auth__case01() // same point between the cent coordinates and the vehicles
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];
        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles", $inputs)
            ->assertOk()
            ->assertJsonCount(15, 'data');
    }

    public function test_list_vehicles_without_auth_case02() // test less than the KM of core
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];

        Vehicle::query()->delete();
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);

        Vehicle::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles", $inputs)
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_list_vehicles_without_auth_case03() // test greater than the KM of core
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];

        Vehicle::query()->delete();
        Vehicle::factory()->create(['coordinates' => '36.7538,3.0588']);
        Vehicle::factory()->create(['coordinates' => '36.7538,3.0588']);
        Vehicle::factory()->create(['coordinates' => '36.5081,1.3078']);

        Vehicle::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-vehicles", $inputs)
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_list_houses_without_auth_case01() // same point between the sent coordinates and the houses
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses", $inputs)
            ->assertOk()
            ->assertJsonCount(15, 'data');
    }

    public function test_list_houses_without_auth_case02() // test less than the KM of core
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];

        House::query()->delete();
        House::factory()->create(['coordinates' => '36.5081,1.3078']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);

        House::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses", $inputs)
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_list_house_without_auth_case03() // test greater than the KM of core
    {
        $inputs = [
            'coordinates' => '36.1580,1.3373',
        ];

        House::query()->delete();
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);

        House::query()->update(['status' => Status::PUBLISHED]);

        $this->authenticated()
            ->json('get', "$this->endpoint/list-houses", $inputs)
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_list_house_without_auth_case04() // when there's no input and no auth
    {
        House::query()->delete();
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.7538,3.0588']);
        House::factory()->create(['coordinates' => '36.5081,1.3078']);

        House::query()->update(['status' => Status::PUBLISHED]);

        $this->json('get', "$this->endpoint/guest-list-houses")
            ->assertStatus(422)
            ->assertJsonValidationErrors(['coordinates']);
    }

    public function test_store_booking__case01() // without coupon code
    {
        $vehicle = Vehicle::factory()->create(['price' => '100000']);
        $vehicle->update(['status' => Status::PUBLISHED]);
        $core = Core::first();
        $core->update(['commission' => 20]);

        $inputs = [
            'bookable_type' => $vehicle->getMorphClass(),
            'bookable_id' => $vehicle->getKey(),
            'payment_type' => PaymentType::DAHABIA,
            'start_date' => '2023-03-10 00:00:00',
            'end_date' => '2023-03-11 00:00:00',
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking", $inputs)
            ->assertCreated()
            ->dump()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'bookable_type',
                    'bookable_id',
                    'bookable',
                    'payment_type',
                    'original_price',
                    'calculated_price',
                    'to_be_paid',
                    'start_date',
                    'end_date',
                    'status',
                    'created_at',
                ],
            ]);

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->getKey(),
            'status' => Status::BOOKED,
        ]);
    }

    public function test_store_booking__case02() // with coupon code
    {
        // when case status is inactive
        $coupon = Coupon::factory()->create(['status' => CouponStatus::INACTIVE, 'system_type' => CouponSystemType::ALL]);

        $vehicle = Vehicle::factory()->create(['price' => '20000']);
        $vehicle->update(['status' => Status::PUBLISHED]);

        $inputs = [
            'bookable_type' => $vehicle->getMorphClass(),
            'bookable_id' => $vehicle->getKey(),
            'payment_type' => PaymentType::DAHABIA,
            'start_date' => '2023-03-10 00:00:00',
            'end_date' => '2023-03-12 00:00:00',
            'coupon_code' => $coupon->code,
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.coupon_code_invalid')]);

        // when case system type equal to house
        $coupon->update(['status' => CouponStatus::ACTIVE, 'system_type' => CouponSystemType::HOUSE]);

        $this->authenticated()
            ->json('post', "$this->endpoint/booking", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.coupon_code_invalid')]);

        // when the date is expired
        $coupon->update(['status' => CouponStatus::ACTIVE, 'system_type' => CouponSystemType::VEHICLE, 'type' => CouponType::CUSTOM, 'start_date' => '2023-03-10', 'end_date' => '2023-03-12']);

        $this->authenticated()
            ->json('post', "$this->endpoint/booking", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.coupon_code_invalid')]);

        // when the usage limit is full
        $coupon->update([
            'usage_limit' => 2, 'status' => CouponStatus::ACTIVE, 'system_type' => CouponSystemType::VEHICLE, 'type' => CouponType::CUSTOM, 'start_date' => '2023-03-10', 'end_date' => '2023-04-12',
        ]);
        $coupon->usages()->create(['user_id' => $this->user->id]);
        $coupon->usages()->create(['user_id' => $this->user->id]);

        $this->authenticated()
            ->json('post', "$this->endpoint/booking", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.coupon_code_invalid')]);

    }

    public function test_view_booking__case01() // standard case
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);
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
                    'has_caution',
                    'start_date',
                    'end_date',
                    'status',
                    'created_at',
                ],
            ]);
    }

    public function test_view_booking__case02() // when the user belongs to booking
    {
        $booking = Booking::factory()->create(['user_id' => $this->user->id]);
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
                    'has_caution',
                    'start_date',
                    'end_date',
                    'status',
                    'created_at',
                ],
            ]);
    }

    public function test_view_booking__case03() // when the user doesn't belong to booking
    {
        $booking = Booking::factory()->create();
        $this->authenticated()
            ->json('get', "$this->endpoint/booking/{$booking->id}")
            ->assertStatus(403);
    }

    public function test_decline_booking()
    {
        $vehicle = Vehicle::factory()->create();

        Event::fake([BookingDeclined::class]);
        Notification::fake([\App\Notifications\BookingDeclined::class]);

        $booking = Booking::factory()->create(['user_id' => $this->user->id, 'bookable_type' => $vehicle->getMorphClass(), 'bookable_id' => $vehicle->getKey()]);

        $this->authenticated()
            ->json('post', "$this->endpoint/decline-booking/{$booking->id}")
            ->assertNoContent();

        Event::assertDispatched(BookingDeclined::class);

        Notification::assertCount(Admin::count());

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->getKey(),
            'status' => Status::PUBLISHED,
        ]);
    }

    public function test_list_bookings()
    {
        Booking::factory()->count(4)->create(['user_id' => $this->user->id]);
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
                        'has_caution',
                        'start_date',
                        'end_date',
                        'status',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function test_store_review__case01() // standard case
    {
        $vehicle = Vehicle::factory()->create();

        $inputs = [
            'reviewable_type' => $vehicle->getMorphClass(),
            'reviewable_id' => $vehicle->getKey(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/store-review", $inputs)
            ->assertNoContent();
    }

    public function test_store_review__case02() // when you've already done the review
    {
        $vehicle = Vehicle::factory()->create();

        $inputs = [
            'reviewable_type' => $vehicle->getMorphClass(),
            'reviewable_id' => $vehicle->getKey(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];

        Review::factory()->create($inputs + [
                'user_id' => $this->user->id,
            ]);

        $this->authenticated()
            ->json('post', "$this->endpoint/store-review", $inputs)
            ->assertJsonValidationErrors('reviewable_id');
    }

    public function test_reasons()
    {
        Reason::query()->delete();
        Reason::factory()->count(3)->create(['type' => ReasonTypes::HOUSES]);
        Reason::factory()->count(3)->create(['type' => ReasonTypes::ALL]);

        $inputs = [
            'type' => ReasonTypes::HOUSES,
        ];
        $this->authenticated()
            ->json('get', "$this->endpoint/reasons", $inputs)
            ->assertOk()
            ->assertJsonCount(6, 'data');
    }

    public function test_coupons()
    {
        Coupon::query()->delete();
        Coupon::factory()->count(3)->create(['status' => CouponStatus::ACTIVE]);

        $inputs = [
            'type' => ReasonTypes::HOUSES,
        ];
        $this->authenticated()
            ->json('get', "$this->endpoint/coupons", $inputs)
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_ads()
    {
        $this->authenticated()
            ->json('get', "$this->endpoint/ads")
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_booking_state__case01() // start
    {
        Storage::fake('public');

        $vehicle = Vehicle::factory()->create();
        $booking = Booking::factory()->create(['bookable_id' => $vehicle->getKey(), 'bookable_type' => $vehicle->getMorphClass()]);

        $payload = [
            'state' => 'start',
            'images' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking-state/{$booking->id}", $payload)
            ->assertNoContent();
    }

    public function test_booking_state__case02() // end
    {
        Storage::fake('public');

        $vehicle = Vehicle::factory()->create();
        $booking = Booking::factory()->create(['bookable_id' => $vehicle->getKey(), 'bookable_type' => $vehicle->getMorphClass()]);

        $payload = [
            'state' => 'end',
            'images' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking-state/{$booking->id}", $payload)
            ->assertNoContent();
    }

    public function test_booking_payment_status__case01() // standard case
    {
        $booking = Booking::factory()->create();

        $payload = [
            'payment_status' => PaymentStatus::PAID,
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking-payment-status/{$booking->id}", $payload)
            ->assertNoContent();
    }

    public function test_booking_payment_status__case02() // when the booking is already paid
    {
        $booking = Booking::factory()->create();
        $booking->update(['payment_status' => PaymentStatus::PAID]);

        $payload = [
            'payment_status' => PaymentStatus::PAID,
        ];

        $this->authenticated()
            ->json('post', "$this->endpoint/booking-payment-status/{$booking->id}", $payload)
            ->assertForbidden();
    }
}

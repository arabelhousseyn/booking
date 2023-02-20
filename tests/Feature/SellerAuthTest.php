<?php

namespace Tests\Feature;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class SellerAuthTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/sellers';
    private Seller $seller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seller = Seller::factory()->create(['email' => 'test12@gmail.com']);
    }

    public function test_login_with_email()
    {
        $inputs = [
            'email' => $this->seller->email,
            'password' => 'password',
        ];

        $this->json('post', "$this->endpoint/login", $inputs)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'avatar',
                    'token',
                ],
            ]);
    }

    public function test_login_with_phone()
    {
        $this->seller->update(['phone' => '0000000000']);
        $inputs = [
            'phone' => '0000000000',
            'password' => 'password',
        ];

        $this->json('post', "$this->endpoint/login", $inputs)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'avatar',
                    'token',
                ],
            ]);
    }

    public function test_login_with_wrong_credentials()
    {
        $inputs = [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ];

        $this->json('post', "$this->endpoint/login", $inputs)
            ->assertBadRequest()
            ->assertJson([
                'message' => trans('exceptions.user_login'),
            ]);
    }

    public function test_signup__case01() // case when there's no avatar
    {
        $inputs = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => 'test@gmail.com',
            'phone' => $this->faker->numerify('##########'),
            'coordinates' => '36.1580,1.3373',
            'password' => 'password',
            'avatar' => null,
        ];

        $this->json('post', "$this->endpoint/signup", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'avatar',
                    'token',
                ],
            ]);
    }

    public function test_signup__case02() // case when there's avatar
    {
        Storage::fake('photos');
        $inputs = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => 'test@gmail.com',
            'phone' => $this->faker->numerify('##########'),
            'coordinates' => '36.1580,1.3373',
            'password' => 'password',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this->json('post', "$this->endpoint/signup", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'avatar',
                    'token',
                ],
            ]);
    }

    public function test_otp_phone_number()
    {
        $inputs = [
            'otp' => $this->faker->numerify('######'),
        ];

        $this->json('post', "$this->endpoint/otp/{$this->seller->id}", $inputs)
            ->assertNoContent();

        // check if the otp was inserted

        $this->assertDatabaseHas('sellers', [
            'id' => $this->seller->id,
            'otp' => $inputs['otp'],
        ]);
    }

    public function test_verify_phone_number__case01() // standard case
    {
        $this->seller->update(['otp' => '1234567']);
        $inputs = [
            'otp' => '1234567',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->seller->id}", $inputs)
            ->assertNoContent();

        // check if the otp was inserted

        $this->assertDatabaseHas('sellers', [
            'id' => $this->seller->id,
            'otp' => null,
        ]);
    }

    public function test_verify_phone_number__case02() // when the phone already verified
    {
        $this->seller->update(['otp' => null, 'phone_verified_at' => now()]);
        $inputs = [
            'otp' => '1234567',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->seller->id}", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.otp_validated')]);
    }

    public function test_verify_phone_number__case03() // when the otp is wrong
    {
        $this->seller->update(['otp' => '1234567']);
        $inputs = [
            'otp' => '12345678',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->seller->id}", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.otp_wrong')]);
    }

    public function test_forgot_password__case01() // standard case
    {
        $inputs = [
            'email' => $this->seller->email,
        ];

        $this->json('post', "$this->endpoint/forgot-password", $inputs)
            ->assertNoContent();
    }

    public function test_forgot_password__case02() // case when already the user has been forgotten the password
    {
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert([
            'email' => $this->seller->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $inputs = [
            'email' => $this->seller->email,
        ];

        $this->json('post', "$this->endpoint/forgot-password", $inputs)
            ->assertNoContent();

        // check the database count of password resets

        $this->assertDatabaseCount('password_resets', 1);
    }

    public function test_logout()
    {
        $this->actingAs($this->seller)
            ->json('post', "$this->endpoint/logout")
            ->assertNoContent();

        // check if the token of the user has been deleted

        $this->assertDatabaseMissing('password_resets', [
            'email' => $this->seller->email,
        ]);
    }
}

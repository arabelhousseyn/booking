<?php

namespace Tests\Feature;

use App\Enums\UserDocumentType;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/users';
    private User $userTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userTest = User::factory()->create(['email' => 'test13@gmail.com']);
    }

    public function test_login_with_email()
    {
        $inputs = [
            'email' => $this->userTest->email,
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
                    'can_rent_house',
                    'can_rent_vehicle',
                    'avatar',
                    'token',
                ],
            ]);
    }

    public function test_login_with_phone()
    {
        $this->userTest->update(['phone' => '0000000000']);
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
                    'can_rent_house',
                    'can_rent_vehicle',
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
            'firebase_registration_token' => Str::random(60),
            'country_code' => '213',
        ];

        $this->json('post', "$this->endpoint/signup", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'can_rent_house',
                    'can_rent_vehicle',
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
            'firebase_registration_token' => Str::random(60),
            'country_code' => '213',
        ];

        $this->json('post', "$this->endpoint/signup", $inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'can_rent_house',
                    'can_rent_vehicle',
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

        $this->json('post', "$this->endpoint/otp/{$this->userTest->id}", $inputs)
            ->assertNoContent();

        // check if the otp was inserted

        $this->assertDatabaseHas('users', [
            'id' => $this->userTest->id,
            'otp' => $inputs['otp'],
        ]);
    }

    public function test_verify_phone_number__case01() // standard case
    {
        $this->userTest->update(['otp' => '1234567']);
        $inputs = [
            'otp' => '1234567',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->userTest->id}", $inputs)
            ->assertNoContent();

        // check if the otp was inserted

        $this->assertDatabaseHas('users', [
            'id' => $this->userTest->id,
            'otp' => null,
        ]);
    }

    public function test_verify_phone_number__case02() // when the phone already verified
    {
        $this->userTest->update(['otp' => null, 'phone_verified_at' => now()]);
        $inputs = [
            'otp' => '1234567',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->userTest->id}", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.otp_validated')]);
    }

    public function test_verify_phone_number__case03() // when the otp is wrong
    {
        $this->userTest->update(['otp' => '1234567']);
        $inputs = [
            'otp' => '12345678',
        ];

        $this->json('post', "$this->endpoint/verify-phone-number/{$this->userTest->id}", $inputs)
            ->assertBadRequest()
            ->assertJson(['message' => trans('exceptions.otp_wrong')]);
    }

    public function test_logout()
    {
        $this->authenticated()
            ->json('post', "$this->endpoint/logout")
            ->assertNoContent();

        // check if the token of the user has been deleted

        $this->assertDatabaseMissing('password_resets', [
            'email' => $this->user->email,
        ]);
    }

    public function test_forgot_password__case01() // standard case
    {
        $inputs = [
            'email' => $this->user->email,
        ];

        $this->json('post', "$this->endpoint/forgot-password", $inputs)
            ->assertNoContent();
    }

    public function test_forgot_password__case02() // case when already the user has been forgotten the password
    {
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert([
            'email' => $this->user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $inputs = [
            'email' => $this->user->email,
        ];

        $this->json('post', "$this->endpoint/forgot-password", $inputs)
            ->assertNoContent();

        // check the database count of password resets

        $this->assertDatabaseCount('password_resets', 1);
    }

    public function test_upload_documents()
    {
        UserDocument::query()->delete();
        Storage::fake('public');
        $inputs = [
            'documents' => [
                [
                    'document_type' => UserDocumentType::ID,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                ],
                [
                    'document_type' => UserDocumentType::PASSPORT,
                    'document_image' => UploadedFile::fake()->image('image.png'),
                ],
            ],
        ];
        $this->json('post', "$this->endpoint/documents/{$this->userTest->id}", $inputs)
            ->assertNoContent();

        // check the number of documents uploaded

        $this->assertDatabaseCount('user_documents', 2);
    }
}

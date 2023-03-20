<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $admin = Admin::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->get('dashboard/profile');

        $response->assertOk();
    }

    public function test_user_can_delete_their_account(): void
    {
        $admin = Admin::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->delete('dashboard/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($admin->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $admin = Admin::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->from('dashboard/profile')
            ->delete('dashboard/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('dashboard/profile');

        $this->assertNotNull($admin->fresh());
    }
}

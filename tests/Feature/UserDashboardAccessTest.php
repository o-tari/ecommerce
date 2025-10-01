<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Livewire\Livewire;
use App\Livewire\UserDashboard;
use Tests\TestCase;

class UserDashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function authenticated_and_verified_user_can_access_dashboard()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)
             ->get('/dashboard')
             ->assertSuccessful()
             ->assertSee('Your Dashboard', false);
    }

    /** @test */
    public function unauthenticated_user_is_redirected_from_dashboard()
    {
        $this->get('/dashboard')
             ->assertRedirect('/login');
    }

    /** @test */
    public function unverified_user_is_redirected_from_dashboard()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
             ->get('/dashboard')
             ->assertRedirect(route('verification.notice'));
    }
}

<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class BaseApiTestCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    protected function authenticateUser(): string
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->token = $response->json('data.token');
        return $this->token;
    }

    protected function withAuth(): self
    {
        $this->authenticateUser();
        return $this;
    }

    protected function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function assertApiSuccess($response, string $message = null): void
    {
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ])
                ->assertJson([
                    'success' => true
                ]);

        if ($message) {
            $response->assertJson([
                'message' => $message
            ]);
        }
    }

    protected function assertApiCreated($response, string $message = null): void
    {
        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ])
                ->assertJson([
                    'success' => true
                ]);

        if ($message) {
            $response->assertJson([
                'message' => $message
            ]);
        }
    }

    protected function assertApiError($response, int $status = 400, string $message = null): void
    {
        $response->assertStatus($status)
                ->assertJsonStructure([
                    'success',
                    'message'
                ])
                ->assertJson([
                    'success' => false
                ]);

        if ($message) {
            $response->assertJson([
                'message' => $message
            ]);
        }
    }

    protected function assertApiValidationError($response): void
    {
        $response->assertStatus(422)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'errors'
                ])
                ->assertJson([
                    'success' => false
                ]);
    }

    protected function assertApiUnauthorized($response): void
    {
        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }
}

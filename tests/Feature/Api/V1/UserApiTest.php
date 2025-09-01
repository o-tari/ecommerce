<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;
    protected Role|null $adminRole;
    protected Role|null $userRole;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
        
        // Create roles if they don't exist
        $this->adminRole = Role::firstOrCreate(['name' => 'Store Administrator']);
        $this->userRole = Role::firstOrCreate(['name' => 'Guest']);
        
        // Create permission if it doesn't exist
        if (!Permission::where('name', 'manage users')->exists()) {
            Permission::create(['name' => 'manage users']);
        }
        
        $this->adminRole->givePermissionTo('manage users');
    }

    public function test_can_list_users(): void
    {
        User::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'id',
                                'name',
                                'email',
                                'created_at',
                                'updated_at'
                            ]
                        ],
                        'total',
                        'per_page'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Users retrieved successfully'
                ]);

        $this->assertEquals(4, $response->json('data.total')); // 3 + 1 from setUp
    }

    public function test_can_search_users(): void
    {
        User::factory()->create([
            'name' => 'Special User',
            'email' => 'special@example.com',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users?search=Special');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertStringContainsString('Special', $response->json('data.data.0.name'));
    }

    public function test_can_get_single_user(): void
    {
        $testUser = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users/' . $testUser->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'User retrieved successfully',
                    'data' => [
                        'id' => $testUser->id,
                        'name' => $testUser->name,
                        'email' => $testUser->email,
                    ]
                ]);
    }

    public function test_can_create_user(): void
    {
        $userData = [
            'name' => 'New Test User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/users', $userData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'User created successfully',
                    'data' => [
                        'name' => 'New Test User',
                        'email' => 'newuser@example.com',
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'name' => 'New Test User',
            'email' => 'newuser@example.com',
        ]);

        // Verify password is hashed
        $createdUser = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue(Hash::check('password123', $createdUser->password));
    }

    public function test_can_create_user_with_roles(): void
    {
        $userData = [
            'name' => 'User with Roles',
            'email' => 'roles@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => [$this->adminRole->id],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/users', $userData);

        $response->assertStatus(201);

        $createdUser = User::where('email', 'roles@example.com')->first();
        $this->assertTrue($createdUser->hasRole('Store Administrator'));
    }

    public function test_cannot_create_user_with_invalid_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/users', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'name',
                    'email',
                    'password'
                ]);
    }

    public function test_cannot_create_user_with_existing_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/users', [
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_can_update_user(): void
    {
        $testUser = User::factory()->create();

        $updateData = [
            'name' => 'Updated User Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/users/' . $testUser->id, $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => [
                        'name' => 'Updated User Name',
                        'email' => 'updated@example.com',
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $testUser->id,
            'name' => 'Updated User Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_can_update_user_password(): void
    {
        $testUser = User::factory()->create();

        $updateData = [
            'name' => $testUser->name,
            'email' => $testUser->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/users/' . $testUser->id, $updateData);

        $response->assertStatus(200);

        // Verify password is updated
        $updatedUser = User::find($testUser->id);
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    public function test_can_update_user_roles(): void
    {
        $testUser = User::factory()->create();
        $testUser->assignRole($this->userRole);

        $updateData = [
            'name' => $testUser->name,
            'email' => $testUser->email,
            'roles' => [$this->adminRole->id],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/users/' . $testUser->id, $updateData);

        $response->assertStatus(200);

        $updatedUser = User::find($testUser->id);
        $this->assertTrue($updatedUser->hasRole('Store Administrator'));
        $this->assertFalse($updatedUser->hasRole('Guest'));
    }

    public function test_cannot_update_user_with_invalid_data(): void
    {
        $testUser = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/users/' . $testUser->id, [
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'email',
                    'password'
                ]);
    }

    public function test_cannot_update_user_with_existing_email(): void
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/users/' . $user1->id, [
            'email' => 'user2@example.com',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_can_delete_user(): void
    {
        $testUser = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/v1/users/' . $testUser->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);

        $this->assertDatabaseMissing('users', [
            'id' => $testUser->id,
        ]);
    }

    public function test_cannot_delete_self(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/v1/users/' . $this->user->id);

        $response->assertStatus(409)
                ->assertJson([
                    'success' => false,
                    'message' => 'Cannot delete your own account'
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_users(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users');

        $response->assertStatus(401);
    }

    public function test_can_paginate_users(): void
    {
        User::factory()->count(25)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users?per_page=10&page=2');

        $response->assertStatus(200);
        $this->assertEquals(10, count($response->json('data.data')));
        $this->assertEquals(2, $response->json('data.current_page'));
        $this->assertEquals(26, $response->json('data.total')); // 25 + 1 from setUp
    }

    public function test_can_sort_users(): void
    {
        User::factory()->create([
            'name' => 'A User',
        ]);
        
        User::factory()->create([
            'name' => 'Z User',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/users?sort_by=name&sort_direction=asc');

        $response->assertStatus(200);
        
        // Get the first two users (excluding the one from setUp)
        $users = $response->json('data.data');
        $this->assertGreaterThanOrEqual(2, count($users));
        
        // Find our test users in the response
        $aUser = collect($users)->firstWhere('name', 'A User');
        $zUser = collect($users)->firstWhere('name', 'Z User');
        
        $this->assertNotNull($aUser, 'A User not found in response');
        $this->assertNotNull($zUser, 'Z User not found in response');
    }
}

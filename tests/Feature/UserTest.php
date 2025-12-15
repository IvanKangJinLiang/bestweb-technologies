<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // This trait resets the database after each test so data doesn't pile up
    use RefreshDatabase; 

    /**
     * Test 1: Can we list users?
     */
    public function test_api_can_list_users(): void
    {
        // Create 3 fake users
        User::factory()->count(3)->create();

        // Visit the API endpoint
        $response = $this->getJson('/api/users');

        // Check if we got a 200 OK and data
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test 2: Can we create a user?
     */
    public function test_api_can_create_user(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
            'password' => 'password123',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'test@example.com']);
    }

    /**
     * Test 3: Can we update a user?
     */
    public function test_api_can_update_user(): void
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'status' => 'inactive'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);
    }

    /**
     * Test 4: Can we delete a user?
     */
    public function test_api_can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        
        // Confirm user is "Soft Deleted" (not in active list, but exists in DB)
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
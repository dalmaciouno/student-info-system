<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OessApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_endpoint_is_available(): void
    {
        $this->getJson('/api/health')
            ->assertOk()
            ->assertJson(['status' => 'ok']);
    }

    public function test_login_token_authenticates_the_current_user(): void
    {
        User::create([
            'id' => 'USR-001',
            'username' => 'student',
            'password' => 'password123',
            'role' => 'Student',
            'name' => 'Demo Student',
            'studentNumber' => 'STU-001',
            'status' => 'Active',
        ]);

        $response = $this->postJson('/api/login', [
            'username' => 'student',
            'password' => 'password123',
        ])->assertOk()
            ->assertJsonPath('user.username', 'student');

        $this->withToken($response->json('token'))
            ->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('username', 'student');
    }

    public function test_demo_seeder_creates_the_documented_login(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'username' => 'student',
            'role' => 'Student',
        ]);
    }

    public function test_api_allows_the_local_vite_frontend_origin(): void
    {
        $this->withHeaders([
            'Origin' => 'http://localhost:5173',
            'Access-Control-Request-Method' => 'POST',
        ])->options('/api/login')
            ->assertNoContent()
            ->assertHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_email_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_login_password_required()
    {
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_login_fails_with_wrong_credentials()
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }
}

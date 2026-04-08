<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_min_length()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_mismatch()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/mypage/profile');
    }
}

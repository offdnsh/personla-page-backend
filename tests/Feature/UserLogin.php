<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserLogin extends TestCase
{

    use WithFaker;

    public function test_on_invalid_data()
    {
        $response = $this->post('/api/auth/signin', [
            'email' => $this->faker->email,
            'password' => 'ivalid-password'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_on_successful_login()
    {
        $response = $this->post('/api/auth/signin', [
            'email' => 'kulikov.lev@zdanov.com',
            'password' => 'password'
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'token' => [
                    'type', 'value', 'expires_in'
                ]
            ]);
    }
}

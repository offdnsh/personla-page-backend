<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserRegistration extends TestCase
{

    use WithFaker;

    public function test_on_invalid_data()
    {
        $response = $this->post('/api/auth/signup', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'username', 'email', 'password'
        ]);
    }

    public function test_for_successful_registration()
    {
        $response = $this->post('/api/auth/signup', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => 'password'
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'token' => [
                    'type', 'value', 'expires_in'
                ]
            ]);
    }
}



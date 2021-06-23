<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserMe extends TestCase
{
    public function test_get_data_authorized_user()
    {

        $user = User::factory()->create();
        $user->profile()->create();

        $token = auth()->login($user);

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->get('/api/auth/me');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_get_data_unauthorized_user()
    {
        $response = $this->get('/api/auth/me');

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_get_data_user_with_wrong_token()
    {
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . bin2hex(random_bytes(8))
            ])
            ->get('/api/auth/me');

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }
}

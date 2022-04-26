<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate()
    {
        $user = User::factory()->create();

        $response = $this->post(route('users.signIn'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertNotNull(\Auth::user());

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('user', $user)
                ->etc()
            );
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->post(route('users.signIn'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertNull(\Auth::user());
    }
}

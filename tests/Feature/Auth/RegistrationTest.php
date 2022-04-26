<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_can_register()
    {
        $response = $this->post(route('users.signUp'), [
            'name' => 'user-test',
            'email' => 'test@test.test',
            'password' => 'test-pass123@A',
            'password_confirmation' => 'test-pass123@A',
        ]);

        $user = User::where('email','test@test.test')->first();

        $this->assertNotNull($user);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('user.id', $user->id)
                ->etc()
            );
    }
}

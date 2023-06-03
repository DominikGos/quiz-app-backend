<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login_into_app(): void
    {
        $user = $this->user;

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertOk();

        $this->assertAuthenticated('sanctum');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $response = $this->postJson(route('logout'));

        $response
            ->assertNoContent();
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson(route('logout'));

        $response
            ->assertUnauthorized();
    }

}

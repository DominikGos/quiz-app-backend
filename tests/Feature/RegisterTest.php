<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_user_can_register(): void
    {
        $user = User::factory()->make();

        $response = $this->postJson(route('register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('user.name', $user->name);
    }

    public function test_user_cannot_register_with_bad_credentials(): void
    {
        $user = User::factory()->make();

        $response = $this->postJson(route('register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => null,
        ]);

        $response
            ->assertUnprocessable();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_can_view_user_list(): void
    {
        $response = $this->getJson(route('users.index'));

        $response
            ->assertOk()
            ->assertJsonIsArray('users');
    }

    public function test_user_can_view_single_user(): void
    {
        $user = $this->user;

        $response = $this->getJson(route('users.show', $user->id));

        $response
            ->assertOk()
            ->assertJsonPath('user.name', $user->name);
    }

    public function test_user_gets_error_if_he_tries_to_view_user_that_does_not_exist(): void
    {
        $userId = 99999;

        $response = $this->getJson(route('users.show', $userId));

        $response
            ->assertNotFound();
    }
}

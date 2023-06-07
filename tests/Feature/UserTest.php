<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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

    public function test_user_can_update_own_profile(): void
    {
        $user = $this->user;
        $updatedUserData = User::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('users.update', $user->id), [
            'name' => $updatedUserData->name,
            'email' => $updatedUserData->email
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('user.name', $updatedUserData->name);
    }

    public function test_user_cannot_update_not_his_profile(): void
    {
        $user = $this->user;
        $profile = User::factory()->create();
        $updatedUserData = User::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('users.update', $profile->id), [
            'name' => $updatedUserData->name,
            'email' => $updatedUserData->email
        ]);

        $response
            ->assertForbidden();
    }

    public function test_user_can_delete_own_profile(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('users.destroy', $user->id));

        $response
            ->assertNoContent();
    }

    public function test_user_cannot_delete_not_his_profile(): void
    {
        $user = $this->user;
        $profile = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('users.destroy', $profile->id));

        $response
            ->assertForbidden();
    }
}

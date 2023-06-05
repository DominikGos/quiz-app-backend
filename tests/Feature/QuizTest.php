<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuizTest extends TestCase
{
    public function test_user_can_view_single_quiz(): void
    {
        $quiz = $this->quiz;

        $response = $this->getJson(route('quizzes.get', ['id' => $quiz->id]));

        $response
            ->assertOk()
            ->assertJsonIsObject('quiz')
            ->assertJsonFragment(['name' => $quiz->name]);
    }

    public function test_user_gets_error_if_he_tries_to_viewing_quiz_that_does_not_exist(): void
    {
        $id = 99999;

        $response = $this->getJson(route('quizzes.get', ['id' => $id]));

        $response
            ->assertNotFound()
            ->assertJsonMissingPath('quiz.id');
    }

    public function test_user_can_view_quiz_list(): void
    {
        $quizzes[] = $this->quiz;

        $response = $this->getJson(route('quizzes.index'));

        $response
            ->assertOk()
            ->assertJsonIsArray('quizzes');
    }

    public function test_user_can_store_quiz_with_correct_credentials(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $quiz = Quiz::factory()->for($user)->make();

        $response = $this->postJson(route('quizzes.store'), [
            'name' => $quiz->name
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('quiz.name', $quiz->name);
    }

    public function test_user_cannot_store_quiz_with_incorrect_credentials(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $response = $this->postJson(route('quizzes.store'), [
            'name' => null
        ]);

        $response
            ->assertUnprocessable();
    }

    public function test_user_can_update_own_quiz(): void
    {
        $user = $this->user;
        $updatedQuizData = Quiz::factory()->make();
        $quiz = $this->quiz;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('quizzes.update', $quiz->id), [
            'name' => $updatedQuizData->name
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('quiz.name', $updatedQuizData->name);
    }

    public function test_user_cannot_update_quiz_he_is_not_author_of(): void
    {
        $user = User::factory()->create();
        $updatedQuizData = Quiz::factory()->make();
        $quiz = $this->quiz;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('quizzes.update', $quiz->id), [
            'name' => $updatedQuizData->name
        ]);

        $response
            ->assertForbidden()
            ->assertJsonMissingPath('quiz.name');
    }
}

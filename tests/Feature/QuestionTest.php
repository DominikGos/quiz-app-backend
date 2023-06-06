<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function test_user_can_view_single_question(): void
    {
        $question = $this->question;

        $response = $this->getJson(route('questions.get', ['id' => $question->id]));

        $response
            ->assertOk()
            ->assertJsonIsObject('question')
            ->assertJsonFragment(['content' => $question->content]);
    }

    public function test_user_gets_error_if_he_tries_to_viewing_question_that_does_not_exist(): void
    {
        $id = 99999;

        $response = $this->getJson(route('questions.get', ['id' => $id]));

        $response
            ->assertNotFound()
            ->assertJsonMissingPath('question.id');
    }

    public function test_user_can_store_question_with_correct_credentials(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $quiz = $this->quiz;
        $question = Question::factory()->for($quiz)->make();

        $response = $this->postJson(route('questions.store'), [
            'quiz_id' => $quiz->id,
            'content' => $question->content
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('question.content', $question->content);
    }

    public function test_user_cannot_store_question_with_incorrect_credentials(): void
    {
        $user = $this->user;

        Sanctum::actingAs($user);

        $response = $this->postJson(route('questions.store'), [
            'quiz_id' => null,
            'content' => null
        ]);

        $response
            ->assertUnprocessable();
    }

    public function test_user_cannot_store_question_in_quiz_that_does_not_belong_to_him(): void
    {
        $user = User::factory()->create();
        $authorOfQuiz = $this->user;

        Sanctum::actingAs($user);

        $quiz = $this->quiz;
        $question = Question::factory()->for($quiz)->make();

        $response = $this->postJson(route('questions.store'), [
            'quiz_id' => $quiz->id,
            'content' => $question->content
        ]);

        $response
            ->assertForbidden();
    }

    public function test_user_can_update_question_in_his_own_quiz(): void
    {
        $user = $this->user;
        $quiz = $this->quiz;
        $question = $this->question;
        $updatedQuestionData = Question::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('questions.update', $question->id), [
            'content' => $updatedQuestionData->content,
            'quiz_id' => $quiz->id
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('question.content', $updatedQuestionData->content);
    }

    public function test_user_cannot_update_question_that_does_not_belong_to_his_quiz(): void
    {
        $user = User::factory()->create();
        $quiz = $this->quiz;
        $question = $this->question;
        $updatedQuestionData = Question::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('questions.update', $question->id), [
            'content' => $updatedQuestionData->content,
            'quiz_id' => $quiz->id
        ]);

        $response
            ->assertForbidden();
    }

    public function test_user_can_delete_question_in_own_quiz(): void
    {
        $user = $this->user;
        $quiz = $this->quiz;
        $question = $this->question;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('questions.destroy', $question->id));

        $response
            ->assertNoContent();
    }

    public function test_user_cannot_delete_question_in_quiz_he_is_not_author_of(): void
    {
        $user = User::factory()->create();
        $question = $this->question;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('questions.destroy', $question->id));

        $response
            ->assertForbidden();
    }
}

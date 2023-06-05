<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    public function test_user_can_view_single_answer(): void
    {
        $answer = $this->answer;

        $response = $this->getJson(route('answers.get', ['id' => $answer->id]));

        $response
            ->assertOk()
            ->assertJsonIsObject('answer')
            ->assertJsonFragment(['content' => $answer->content]);
    }

    public function test_user_gets_error_if_he_tries_to_viewing_answer_that_does_not_exist(): void
    {
        $id = 99999;

        $response = $this->getJson(route('answers.get', ['id' => $id]));

        $response
            ->assertNotFound()
            ->assertJsonMissingPath('answer.id');
    }

    public function test_user_can_store_answer_in_the_quiz_he_is_author_of(): void
    {
        $user = $this->user;
        $answer = Answer::factory()->make();
        $question = $this->question;

        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'), [
            'question_id' => $question->id,
            'content' => $answer->content,
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('answer.content', $answer->content);
    }

    public function test_user_cannot_store_answer_in_the_quiz_he_is_not_author_of(): void
    {
        $user = User::factory()->create();
        $answer = Answer::factory()->make();
        $question = $this->question;

        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'), [
            'question_id' => $question->id,
            'content' => $answer->content,
        ]);

        $response
            ->assertForbidden()
            ->assertJsonMissingPath('answer.content');
    }

    public function test_user_cannot_store_more_than_four_answers_to_a_question(): void
    {
        $user = $this->user;
        $answer = Answer::factory()->make();
        $question = $this->question;
        Answer::factory()->for($question)->count(4)->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'), [
            'question_id' => $question->id,
            'content' => $answer->content,
        ]);

        $response
            ->assertForbidden()
            ->assertJsonMissingPath('answer.content');
    }
}

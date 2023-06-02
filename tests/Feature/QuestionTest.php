<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_user_can_view_question_list(): void
    {
        $questions[] = $this->question;

        $response = $this->getJson(route('questions.index'));

        $response
            ->assertOk()
            ->assertJsonIsArray('questions');
    }
}

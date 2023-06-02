<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_user_can_view_answer_list(): void
    {
        $answers[] = $this->answer;

        $response = $this->getJson(route('answers.index'));

        $response
            ->assertOk()
            ->assertJsonIsArray('answers');
    }
}

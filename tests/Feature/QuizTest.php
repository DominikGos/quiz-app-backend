<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizTest extends TestCase
{
    public function test_user_can_view_single_quiz(): void
    {
        $quiz = $this->quiz;

        $response = $this->getJson(route('quizzes.get', ['id' => $quiz->id]));

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $this->quiz->name]);
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
}

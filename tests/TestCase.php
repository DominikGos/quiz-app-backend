<?php

namespace Tests;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $seed = true;
    protected Quiz $quiz;
    protected Quiz $unpublishedQuiz;
    protected Question $question;
    protected Answer $answer;
    protected User $user;

    function setUp(): void
    {
        parent::setUp();

        $this->quiz = Quiz::first();
        $this->unpublishedQuiz = Quiz::where('is_published', false)->first();
        $this->question = Question::first();
        $this->answer = Answer::first();
        $this->user = User::first();
    }
}

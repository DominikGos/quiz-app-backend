<?php

namespace Tests;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $seed = true;
    protected Quiz $quiz;
    protected Question $question;
    protected Answer $answer;

    function setUp(): void
    {
        parent::setUp();

        $this->quiz = Quiz::first();
        $this->question = Question::first();
        $this->answer = Answer::first();
    }
}

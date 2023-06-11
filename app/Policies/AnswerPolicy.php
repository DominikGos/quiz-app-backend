<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class AnswerPolicy
{
    use HasAuthor;

    public function store(User $user, Answer $answer): bool
    {
        if($answer->question->answers()->count() > Question::$limitOfAnswers)
            return false;

        if($this->whetherUserIsAuthorOf($user, $answer->question->quiz))
            return true;

        return false;
    }

    public function update(User $user, Answer $answer): bool
    {
        return $this->whetherUserIsAuthorOf($user, $answer->question->quiz);
    }

    public function destroy(User $user, Answer $answer): bool
    {
        return $this->whetherUserIsAuthorOf($user, $answer->question->quiz);
    }
}

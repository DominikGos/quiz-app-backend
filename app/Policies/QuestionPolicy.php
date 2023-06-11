<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    use HasAuthor;
    
    public function storeAnswer(User $user, Question $question): bool
    {
        if($question->answers()->count() > Question::$limitOfAnswers)
            return false;

        if($this->whetherUserIsAuthorOf($user, $question->quiz))
            return true;

        return false;
    }
}

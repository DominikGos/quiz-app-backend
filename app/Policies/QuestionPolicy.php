<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

class QuestionPolicy
{
    use HasAuthor;

    public function store(User $user, Question $question): bool
    {
        return $this->whetherUserIsAuthorOf($user, $question->quiz);
    }

    public function update(User $user, Question $question): bool
    {
        return $this->whetherUserIsAuthorOf($user, $question->quiz);
    }

    public function destroy(User $user, Question $question): bool
    {
        return $this->whetherUserIsAuthorOf($user, $question->quiz);
    }
}

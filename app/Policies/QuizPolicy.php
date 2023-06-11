<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    use HasAuthor;

    public function update(User $user, Quiz $quiz): bool
    {
        return $this->whetherUserIsAuthorOf($user, $quiz);
    }

    public function destroy(User $user, Quiz $quiz): bool
    {
        return $this->whetherUserIsAuthorOf($user, $quiz);
    }

    public function publish(User $user, Quiz $quiz): bool
    {
        return $this->whetherUserIsAuthorOf($user, $quiz);
    }

    public function unpublish(User $user, Quiz $quiz): bool
    {
        return $this->whetherUserIsAuthorOf($user, $quiz);
    }
}

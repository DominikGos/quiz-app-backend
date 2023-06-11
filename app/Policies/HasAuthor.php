<?php

namespace App\Policies;

use App\Models\User;

trait HasAuthor
{
    public function whetherUserIsAuthorOf(User $user, mixed $resource): bool
    {
        return $user->id === $resource->user_id;
    }
}

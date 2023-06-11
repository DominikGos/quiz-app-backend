<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    private function whetherUserIsAuthorOfProfile(User $user, User $profile): bool
    {
        return $user->id === $profile->id;
    }

    public function update(User $user, User $profile): bool
    {
        return $this->whetherUserIsAuthorOfProfile($user, $profile);
    }

    public function destroy(User $user, User $profile): bool
    {
        return $this->whetherUserIsAuthorOfProfile($user, $profile);
    }
}

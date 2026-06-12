<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;

class EntryPolicy
{
    public function view(User $user, Entry $entry): bool
    {
        return $user->id === $entry->user_id;
    }

    public function update(User $user, Entry $entry): bool
    {
        return $user->id === $entry->user_id;
    }

    public function delete(User $user, Entry $entry): bool
    {
        return $user->id === $entry->user_id;
    }
}

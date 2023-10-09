<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

class HabitPolicy
{
    // only authorize user can manage habit related tasks
    public function manage(User $user, Habit $habit): bool
    {
        return $user->is($habit->user);
    }

    public function view(User $user, Habit $habit): bool
    {
        return $user->is($habit->user);
    }

    public function update(User $user, Habit $habit): bool
    {
        return $user->is($habit->user);
    }

    public function delete(User $user, Habit $habit): bool
    {
        return $user->is($habit->user);
    }
}

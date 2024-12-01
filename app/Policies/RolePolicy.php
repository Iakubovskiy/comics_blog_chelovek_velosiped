<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function hasRole(User $user, string $role)
    {
        dump($user->role->name);
        sleep(30);
        dump($role);
        return $user->role && $user->role->name === $role;
    }
}

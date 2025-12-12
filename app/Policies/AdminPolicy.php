<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    protected $policies = [
        User::class => AdminPolicy::class,
    ];

    public function manageAdmin(User $user)
    {
        return $user->role === 'superadmin';
    }
}

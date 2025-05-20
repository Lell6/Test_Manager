<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class StudentTestPolicy
{
    public function manage(User $user)
    {
        return $user && $user->type_id === 1
            ? Response::allow()
            : Response::deny();
    }

    public function view(?User $user): Response
    {
        return $user && $user->type_id === 1
            ? Response::allow()
            : Response::deny();
    }
}

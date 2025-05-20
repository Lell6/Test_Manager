<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class QuestionPolicy
{
    public function manage(User $user)
    {
        return $user && $user->type_id === 2
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function view(?User $user): Response
    {
        return $user && $user->type_id === 2
            ? Response::allow()
            : Response::deny();
    }
}

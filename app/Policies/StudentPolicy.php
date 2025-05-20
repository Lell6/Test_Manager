<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StudentPolicy
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

    public function viewSelected(User $authUser, User $student): Response
    {
        return ($authUser->id == $student->id || $authUser->type_id === 2)
            ? Response::allow()
            : Response::deny();
    }
}

<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Group;
use App\Models\GroupStudentList;
use App\Models\User;
use App\Repositories\GroupStudentRepository;

class GroupPolicy
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

    public function viewSelected(User $authUser, Group $group): Response
    {
        $isInGroup = (new GroupStudentRepository(new GroupStudentList()))->isStudentInGroup($authUser->id, $group->id);
        return ($isInGroup || $authUser->type_id === 2)
            ? Response::allow()
            : Response::deny();
    }
}

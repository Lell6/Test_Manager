<?php

namespace App\Policies;

use App\Models\Group;
use Illuminate\Auth\Access\Response;

use App\Models\User;
use App\Models\Test;
use App\Models\GroupStudentList;
use App\Models\TestStudentAssignment;
use App\Repositories\GroupRepository;
use App\Repositories\GroupStudentRepository;
use App\Repositories\TestRepository;
use App\Repositories\TestStudentRepository;

class TestPolicy
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

    public function viewRequired(User $authUser, User $student): Response
    {
        return ($authUser->id == $student->id || $authUser->type_id === 2)
            ? Response::allow()
            : Response::deny();
    }

    public function viewSelected(User $authUser, Test $test, User $student): Response
    {
        $userId = $authUser->id;
        $testId = $test->id;

        $isAssignedByGroup = false;
        $groups = (new TestRepository($test))->getTestGroups($testId);
        foreach ($groups as $group) {
            if ((new GroupStudentRepository(new GroupStudentList()))->isStudentInGroup($userId, $group->id)) {
                $isAssignedByGroup = true;
                break;
            }
        }
        $isAssignedByStudent = (new TestStudentRepository(new TestStudentAssignment()))->isTestAssignedToStudent($userId, $testId);

        if ($authUser->id == $student->id && ($isAssignedByGroup || $isAssignedByStudent)) {
            return Response::allow();
        }

        return ($authUser->type_id === 2)
            ? Response::allow()
            : Response::deny();
    }
}

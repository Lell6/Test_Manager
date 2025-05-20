<?php

namespace App\Repositories;
use App\Models\Group;

class GroupRepository extends BaseRepository {
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function getGroupsForTable() {
        return $this->buildQuery([], ['id', 'name']);
    }

    public function getGroups() {
        return $this->get([], ['id', 'name']);
    }

    public function getGroupsSearch($searchValue) {
        $conditions = [
            'name' => ['LIKE', $searchValue],
        ];
        $columns = ['id', 'name'];

        return $this->get($conditions, $columns);
    }

    public function studentInGroup($studentId, $groupId) {
        return $this->exists(['id' => $groupId], [], ['students:id'], ['id' => $studentId]);
    }
}
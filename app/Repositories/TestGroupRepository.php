<?php

namespace App\Repositories;
use App\Models\TestGroupAssignment;

class TestGroupRepository extends BaseRepository {
    public function __construct(TestGroupAssignment $model)
    {
        parent::__construct($model);
    }

    public function getTestGroupIds($testId) {
        return $this->get(['test_id' => $testId], ['group_id']);
    }

    public function getGroupsTests($groupIds) {
        $conditions = [
            'group_id' => ['IN', $groupIds],
        ];

        $tests = $this->get($conditions);
        return $tests->unique('test_id');
    }

    public function hasTestGroups($testId) {
        $result = [
            'type' => 'group',
            'exists' => $this->exists(['test_id' => $testId], ['group_id']),
        ];
        return $result;
    }

    public function isTestAssignedToStudent($groupId, $testId) {
        return $this->exists(['group_id' => $groupId, 'test_Id' => $testId ]);
    }
}
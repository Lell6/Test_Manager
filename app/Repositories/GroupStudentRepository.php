<?php

namespace App\Repositories;
use App\Models\GroupStudentlist;

class GroupStudentRepository extends BaseRepository {
    public function __construct(GroupStudentList $model)
    {
        parent::__construct($model);
    }

    public function getGroupStudentIds($groupId) {
        return $this->get(['group_id' => $groupId], ['student_id']);
    }

    public function getStudentGroups($student_id) {
        return $this->get(['student_id' => $student_id], ['group_id']);
    }

    public function isStudentInGroup($studentId, $groupId) {
        return $this->exists(['student_id' => $studentId, 'group_id' => $groupId]);
    }
}
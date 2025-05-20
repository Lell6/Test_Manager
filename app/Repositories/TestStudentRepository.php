<?php

namespace App\Repositories;
use App\Models\TestStudentAssignment;

class TestStudentRepository extends BaseRepository {
    public function __construct(TestStudentAssignment $model)
    {
        parent::__construct($model);
    }

    public function getTestStudentIds($testId) {
        return $this->get(['test_id' => $testId], ['student_id']);
    }

    public function getStudentTests($studentId) {
        return $this->get(['student_id' => $studentId], [], ['test']);
    }

    public function hasTestStudents($testId) {
        $result = [
            'type' => 'student',
            'exists' => $this->exists(['test_id' => $testId], ['student_id']),
        ];
        return $result;
    }

    public function isTestAssignedToStudent($studentId, $testId) {
        return $this->exists(['student_id' => $studentId, 'test_Id' => $testId ]);
    }
}
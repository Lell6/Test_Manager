<?php

namespace App\Repositories;
use App\Models\StudentTestResult;

class StudentTestRepository extends BaseRepository {
    public function __construct(StudentTestResult $model)
    {
        parent::__construct($model);
    }

    public function getTestsForTable() {
        return $this->buildQuery([], ['id', 'name']);
    }

    public function getTests() {
        return $this->get([], ['id', 'name']);
    }

    public function getNumberOfCompletedQuestionsForTest($student_id, $testId) {
        $questions = $this->get(['test_id' => $testId, 'student_id' => $student_id], ['question_id']);
        return count($questions);
    }
}
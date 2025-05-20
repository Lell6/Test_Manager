<?php

namespace App\Repositories;
use App\Models\TestSnapshot;

use function Symfony\Component\Clock\now;

class TestSnapshotRepository extends BaseRepository {
    public function __construct(TestSnapshot $model)
    {
        parent::__construct($model);
    }

    public function getSnapshotForStudentForTest($studentId, $testId) {
        return $this->getFirst(['student_id' => $studentId, 'test_id' => $testId]);
    }

    public function isTestCompletedForStudent($studentId, $testId) {
        $isCompleted = $this->getFirst(['student_id' => $studentId, 'test_id' => $testId], ['completed_at']);
        return ($isCompleted && $isCompleted['completed_at']) ? $isCompleted['completed_at'] : false;
    }

    public function isTestCompletedByAnyone($testId) {
        return $this->exists(['test_id' => $testId], ['completed_at']);
    }
    
    public function setTestSnapshotForStudent($studentId, $test) {
        $snapshot = [
            'student_id' => $studentId,
            'test_id' => $test['id'],
            'test_structure' => json_encode($test),
        ];

        return $this->save($snapshot);
    }

    public function updateTestSnapshotForStudent($studentId, $test, $snapshotId) {
        $snapshot = [
            'student_id' => $studentId,
            'test_id' => $test['id'],
            'test_structure' => json_encode($test),
        ];

        return $this->update(['id' => $snapshotId], $snapshot);
    }

    public function markTestAsCompleted($snapshot, $test, $correctCount) {
        $snapshot->correct_answers_count = $correctCount;
        $snapshot->completed_at = now();
        $snapshot->test_structure = $test;
        
        $this->updateFromObject($snapshot);
    } 
}
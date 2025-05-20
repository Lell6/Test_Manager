<?php

namespace App\Repositories;
use App\Models\Test;

class TestRepository extends BaseRepository {
    public function __construct(Test $model)
    {
        parent::__construct($model);
    }

    public function getTestsForTable() {
        return $this->buildQuery([], ['id', 'name']);
    }

    public function getTestById($testId) {
        return $this->getFirst(['id' => $testId], [], ['questions']);
    }

    public function getTests() {
        return $this->get([], ['id', 'name', 'is_individual']);
    }

    public function getTestGroups($testId) {
        $groups = $this->getfirst(['id' => $testId], [], ['groups']);
        return $groups->groups;
    }
}
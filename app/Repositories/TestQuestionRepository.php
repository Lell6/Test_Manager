<?php

namespace App\Repositories;
use App\Models\TestQuestionlist;

class TestQuestionRepository extends BaseRepository {
    public function __construct(TestQuestionList $model)
    {
        parent::__construct($model);
    }

    public function getTestQuestionIds($testId) {
        return $this->get(['test_id' => $testId], ['question_id']);
    }

    public function getNumberOfQuestionsForTest($testId) {
        $questions = $this->get(['test_id' => $testId], ['question_id']);
        return count($questions);
    }
}
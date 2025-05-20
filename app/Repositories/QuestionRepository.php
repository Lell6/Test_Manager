<?php

namespace App\Repositories;
use App\Models\Question;

class QuestionRepository extends BaseRepository {
    public function __construct(Question $model)
    {
        parent::__construct($model);
    }

    public function getQuestions($searchValue = null) {
        $conditions = ($searchValue) 
            ? [ 'question' => ['LIKE', $searchValue], ]
            : [];

        $columns = ['id', 'question'];

        return $this->get($conditions, $columns);
    }
}
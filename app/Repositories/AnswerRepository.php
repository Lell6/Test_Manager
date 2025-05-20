<?php

namespace App\Repositories;
use App\Models\Answer;

class AnswerRepository extends BaseRepository {
    public function __construct(Answer $model)
    {
        parent::__construct($model);
    }

    public function getQuestionAnswers($questionId) {
        return $this->get(['question_id' => $questionId], ['id', 'answer', 'is_correct']);
    }

    public function isCorrectAnswer($answerId) {
        $isCorrect = $this->getFirst(['id' => $answerId], ['is_correct']);
        return $isCorrect['is_correct'] == 1;
    }

    public function deleteUnaffected($affectedIds, $questionId) {
        $conditions = [
            'id' => ['NOT IN', $affectedIds],
            'question_id' => $questionId
        ];
        return $this->delete($conditions);
    }
}
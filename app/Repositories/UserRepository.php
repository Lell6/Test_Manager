<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository extends BaseRepository {
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsersWithoutProjectOwner($ownerId) {
        return $this->get(['id' => ['<>', $ownerId]], ['id', 'name', 'surname']);
    }

    public function getStudent($studentId) {
        return $this->getFirst(['id' => $studentId]);
    }

    public function getStudents($searchValue = null) {
        $conditions = [
            'type_id' => ['=', 1],
        ];

        if ($searchValue) {
            $conditions['OR'] = [
                'name' => ['LIKE', $searchValue],
                'surname' => ['LIKE', $searchValue],
            ];
        }

        $columns = ['id', 'name', 'surname'];
        return $this->get($conditions, $columns);
    }
}
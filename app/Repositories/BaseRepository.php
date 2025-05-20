<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function buildQuery(array $conditions = [], array $columns = ['id'], array $relations = [], array $relationConditions = []) {
        $query = $this->model->newQuery();
        
        if ($conditions) { $this->buildConditions($query, $conditions); }
        if ($columns) { $query->select($columns); }
        if ($relations) { $query->with($relations); }        
        if ($relationConditions) { $this->buildRelationConditions($query, $relationConditions); }

        return $query;
    }
    
    private function buildConditions(&$query, array $conditions) {
        foreach ($conditions as $key => $value) {
            if (strtoupper($key) === 'OR' && is_array($value)) {
                $query->where(function ($q) use ($value) {
                    foreach ($value as $orKey => $orValue) {
                        $this->applyCondition($q, $orKey, $orValue, true);
                    }
                });
            } else {
                $this->applyCondition($query, $key, $value);
            }
        }
    }
    
    private function applyCondition(&$query, $key, $value, $isOr = false) {
        $methodPrefix = $isOr ? 'orWhere' : 'where';
    
        if (is_array($value)) {
            $operator = strtoupper($value[0]);
            $val = $value[1];
    
            if ($operator === 'IN') {
                $query->{$methodPrefix . 'In'}($key, $val);
            } elseif ($operator === 'NOT IN') {
                $query->{$methodPrefix . 'NotIn'}($key, $val);
            } else {
                $query->{$methodPrefix}($key, $operator, $val);
            }
        } else {
            $query->{$methodPrefix}($key, '=', $value);
        }
    }

    private function buildRelationConditions(&$query, array $relationConditions) {
        foreach ($relationConditions as $relation => $conditions) {
            $query->whereHas($relation, function ($q) use ($conditions) {
                $this->buildConditions($q, $conditions);
            });
        }
    }

    private function buildSyncData(array $relatedObjects, $foreignKey, array $extra = []) {
        $syncData = [];
    
        foreach ($relatedObjects as $relatedObject) {
            $syncData[$relatedObject[$foreignKey]] = $extra;
        }

        return $syncData;
    }

    public function exists(array $conditions = [], array $columns = ['*'], array $relations = []) {
        $query = $this->buildQuery($conditions, $columns, $relations);
        return $query->exists();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function get(array $conditions = [], array $columns = ['*'], array $relations = [], array $relationConditions = []) {
        $query = $this->buildQuery($conditions, $columns, $relations, $relationConditions);
        return $query->get();
    }

    public function getFirst(array $conditions = [], array $columns = ['*'], array $relations = []) {
        $query = $this->buildQuery($conditions, $columns, $relations);
        return $query->first();
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function attach($relationName, $mainId, array $relatedObjects, $foreignKey, array $extra = [])
    {
        $syncData = $this->buildSyncData($relatedObjects, $foreignKey, $extra);
        $this->model->findOrFail($mainId)->$relationName()->syncWithoutDetaching($syncData);
    }
    public function attachWithRemoval($relationName, $mainId, array $relatedObjects, $foreignKey, array $extra = [])
    {
        $syncData = $this->buildSyncData($relatedObjects, $foreignKey, $extra);
        $this->model->findOrFail($mainId)->$relationName()->sync($syncData);
    }

    public function update(array $conditions, array $data)
    {
        $record = $this->getFirst($conditions);
        if ($record) {
            $record->update($data);
        }
        return $record;
    }

    public function updateFromObject($object) {
        return $object->save();
    }

    public function delete(array $conditions)
    {
        $query = $this->buildQuery($conditions);
        return $query->delete();
    }
}
<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function exists();
    public function getAll();
    public function get();    
    public function getFirst();  

    public function save(array $data);
    public function attach($relationName, $mainId, array $relatedObjects, $foreignKey, array $extra = []);
    public function attachWithRemoval($relationName, $mainId, array $relatedObjects, $foreignKey, array $extra = []);

    public function update(array $conditions, array $data);
    public function updateFromObject($object);

    public function delete(array $conditions);

}
<?php
/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 09/11/18
 * Time: 08:11 م
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class Repository implements IRepository
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all($filters, $sortedKey = 'id', $sortedMethod = 'ASC')
    {
        return $this->model->orderBy($sortedKey, $sortedMethod)->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->query()->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function destroy($id): int
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function find($id)
    {
        return $this->model->query()->find($id);
    }

    // Get the associated model
    public function getModel(): Model
    {
        return $this->model;
    }

    // Eager load database relationships
    public function with($relations): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->with($relations);
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query();
    }

    public function whereIn(string $column, array $values): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->whereIn($column, $values);
    }

    public function where(string $column, string $value)
    {
        return $this->model->query()->where($column, $value)->first();
    }
}

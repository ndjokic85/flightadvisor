<?php

namespace App\Repositories\Eloquent;

use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
    public function update(int $id, array $attributes)
    {
        return $this->model->whereId($id)->update($attributes);
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function firstOrCreate(array $matchingFields, array $attributes): Model
    {
        return $this->model->firstOrCreate($matchingFields, $attributes);
    }
    public function delete(Model $model)
    {
        $model->delete();
    }
}

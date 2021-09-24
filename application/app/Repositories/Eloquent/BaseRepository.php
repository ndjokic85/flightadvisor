<?php

namespace App\Repositories\Eloquent;

use App\Models\Route;
use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    protected Model $model;

    protected array $baseArgs = ['limit' => 0, 'skip' => 0];

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

    public function all(array $args = []): Collection
    {
        $args = array_merge($this->baseArgs, $args);
        return ($args['limit']) ? $this->model->limit($args['limit'])->offset($args['skip'])->get()
            : $this->model->all();
    }
}

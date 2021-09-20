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

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }
}

<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function create(array $attributes): Model;
    public function delete(Model $model);
    public function find(int $id): ?Model;
    public function update(int $id, array $attributes);
    public function all(int $limit = null, int $skip = 0): Collection;
    public function firstOrCreate(array $matchingFields, array $attributes): Model;
}

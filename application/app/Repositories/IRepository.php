<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function create(array $attributes): Model;
    public function find(int $id): ?Model;
    public function firstOrCreate(array $matchingFields, array $attributes): Model;
}

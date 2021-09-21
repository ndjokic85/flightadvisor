<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\ICityRepository;

class CityRepository extends BaseRepository implements ICityRepository
{

    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function findByName(string $name): ?City
    {
        return $this->model->where('name', $name)->first();
    }
}

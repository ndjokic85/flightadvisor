<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Models\Role;
use App\Repositories\ICityRepository;
use App\Repositories\IRoleRepository;
use Illuminate\Support\Collection;

class CityRepository extends BaseRepository implements ICityRepository
{

    public function __construct(City $model)
    {
        parent::__construct($model);
    }

}

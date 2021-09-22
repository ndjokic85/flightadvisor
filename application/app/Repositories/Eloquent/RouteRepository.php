<?php

namespace App\Repositories\Eloquent;

use App\Models\Route;
use App\Repositories\IRouteRepository;

class RouteRepository extends BaseRepository implements IRouteRepository
{

    public function __construct(Route $model)
    {
        parent::__construct($model);
    }

}

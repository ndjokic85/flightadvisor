<?php

namespace App\Repositories\Eloquent;

use App\Models\Airport;
use App\Repositories\IAirportRepository;

class AirportRepository extends BaseRepository implements IAirportRepository
{

    public function __construct(Airport $model)
    {
        parent::__construct($model);
    }

}

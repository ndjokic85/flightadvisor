<?php

namespace App\Repositories\Eloquent;

use App\Models\Route;
use App\Repositories\IRouteRepository;
use Illuminate\Database\Eloquent\Collection;

class RouteRepository extends BaseRepository implements IRouteRepository
{

    public function __construct(Route $model)
    {
        parent::__construct($model);
    }

    public function allGrouppedBy(string $column): Collection
    {
        return $this->model->get()->groupBy($column);
    }

    public function findBySourceAndDestination(int $source, int $destination): Route
    {
        return $this->model->where('source_airport_id', $source)
            ->where('destination_airport_id', $destination)->first();
    }
}

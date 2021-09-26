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

    public function allGrouppedBySourceAirport(): array
    {
        return $this->model->select('source_airport_id', 'destination_airport_id', 'price')
            ->get()->groupBy('source_airport_id')->transform(function ($item) {
                return Collection::wrap($item)->mapWithKeys(function ($item) {
                    return [$item->destination_airport_id => $item->price];
                });
            })->all();
    }

    public function findBySourceAndDestination(int $source, int $destination): Route
    {
        return $this->model->where('source_airport_id', $source)
            ->where('destination_airport_id', $destination)->first();
    }
}

<?php

namespace App\Repositories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

interface IRouteRepository
{
    public function allGrouppedBySourceAirport(): array;
    public function findBySourceAndDestination(int $source, int $destinaton): Route;
}

<?php

namespace App\Repositories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

interface IRouteRepository
{
    public function allGrouppedBy(string $column): Collection;
    public function findBySourceAndDestination(int $source, int $destinaton): Route;
}

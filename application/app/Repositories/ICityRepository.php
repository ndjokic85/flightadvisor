<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

interface ICityRepository
{
    public function findByName(string $name): ?City;
    public function all(?int $commentsLimit): Collection;
}

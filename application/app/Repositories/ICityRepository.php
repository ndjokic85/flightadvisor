<?php

namespace App\Repositories;

use App\Models\City;

interface ICityRepository
{
    public function findByName(string $name): ?City;
}

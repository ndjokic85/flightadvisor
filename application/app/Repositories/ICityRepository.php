<?php

namespace App\Repositories;

use App\Models\City;

interface ICityRepository
{
    public function findByName(string $name): ?City;
    public function filter(array $args = []);
}

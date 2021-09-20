<?php

namespace App\Repositories;

interface IRoleRepository
{
    public function findRoleIdsByName(string $name): array;
}

<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function findByUsername(string $username): ?Model;
}
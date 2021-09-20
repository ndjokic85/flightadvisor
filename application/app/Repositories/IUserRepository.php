<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function findUserByUsername(string $username): ?Model;
}
<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}

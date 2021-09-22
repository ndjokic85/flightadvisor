<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\IUserRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByUsername(string $username): ?Model
    {
        return $this->model->where('username', $username)->first();
    }
}

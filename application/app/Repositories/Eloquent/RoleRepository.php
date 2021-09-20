<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\IRoleRepository;

class RoleRepository extends BaseRepository implements IRoleRepository
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findRoleIdsByName(string $name): array
    {
        return $this->model->where('name', $name)->pluck('id');
    }
}

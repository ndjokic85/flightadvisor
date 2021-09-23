<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\IRoleRepository;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository implements IRoleRepository
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findRoleIdsByName(string $name): array
    {
        return $this->model->whereName($name)->pluck('id')->toArray();
    }
}

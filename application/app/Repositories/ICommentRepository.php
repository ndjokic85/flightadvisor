<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ICommentRepository
{
    public function update(int $id, array $attributes);
}

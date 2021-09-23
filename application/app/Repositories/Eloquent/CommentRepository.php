<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Models\Comment;
use App\Repositories\ICommentRepository;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements ICommentRepository
{

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
